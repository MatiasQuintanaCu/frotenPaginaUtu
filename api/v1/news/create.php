<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception('Error de conexión a la base de datos');
    }

    // Obtener datos JSON
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validar datos
    if (empty($data['titulo']) || empty($data['contenido'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Título y contenido son obligatorios']);
        exit;
    }

    // Validar que la imagen sea obligatoria
    if (empty($data['imagen'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'La imagen es obligatoria']);
        exit;
    }

    $titulo = $data['titulo'];
    $contenido = $data['contenido'];
    $imagenBase64 = $data['imagen'];

    // Extraer solo el base64 puro (sin el prefijo data:image/...)
    if (preg_match('/^data:image\/(jpeg|jpg|png|gif|webp);base64,/', $imagenBase64)) {
        // Si viene con prefijo, extraer solo el base64
        $imagenBase64 = preg_replace('/^data:image\/(jpeg|jpg|png|gif|webp);base64,/', '', $imagenBase64);
    }

    // Validar que sea un string base64 válido
    if (!base64_decode($imagenBase64, true)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Formato base64 de imagen inválido']);
        exit;
    }

    // Validar tamaño aproximado (5MB en base64 ≈ 6.6MB)
    if (strlen($imagenBase64) > 6900000) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'La imagen no debe superar 5MB']);
        exit;
    }

    // ID del autor (cambiar por sesión real)
    $id_autor = 1;

    // Insertar post con imagen en base64 PURO (sin prefijo)
    $query = "INSERT INTO posts (titulo, contenido, id_autor, img) 
              VALUES (:titulo, :contenido, :id_autor, :img)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':contenido', $contenido);
    $stmt->bindParam(':id_autor', $id_autor, PDO::PARAM_INT);
    $stmt->bindParam(':img', $imagenBase64);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Noticia creada exitosamente',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        throw new Exception('Error al crear la noticia');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>