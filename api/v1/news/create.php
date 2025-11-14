<?php
session_start();

header('Access-Control-Allow-Origin: http://localhost');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Verificar que el usuario esté autenticado
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['id_usuario'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado. Por favor inicie sesión.']);
        exit;
    }

    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception('Error de conexión a la base de datos');
    }

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validar datos
    if (empty($data['titulo']) || empty($data['contenido'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Título y contenido son obligatorios']);
        exit;
    }

    if (empty($data['imagen'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'La imagen es obligatoria']);
        exit;
    }

    $titulo = $data['titulo'];
    $contenido = $data['contenido'];
    $imagenBase64 = $data['imagen'];

    // Validar formato base64
    if (!preg_match('/^data:image\/(jpeg|jpg|png|gif|webp);base64,/', $imagenBase64)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Formato de imagen inválido']);
        exit;
    }

    // Validar tamaño aproximado
    if (strlen($imagenBase64) > 6900000) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'La imagen no debe superar 5MB']);
        exit;
    }

    // ← REMOVER EL PREFIJO data:image/...;base64,
    $imagenBase64Limpia = preg_replace('/^data:image\/\w+;base64,/', '', $imagenBase64);

    // Obtener ID del usuario autenticado
    $id_autor = $_SESSION['user_id'] ?? $_SESSION['id_usuario'] ?? null;
    
    if (!$id_autor) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'No se pudo obtener el ID del usuario']);
        exit;
    }

    // Insertar post con imagen en base64 LIMPIA (sin prefijo)
    $query = "INSERT INTO posts (titulo, contenido, id_autor, img) 
              VALUES (:titulo, :contenido, :id_autor, :img)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':contenido', $contenido);
    $stmt->bindParam(':id_autor', $id_autor, PDO::PARAM_INT);
    $stmt->bindParam(':img', $imagenBase64Limpia); // ← Guardar sin prefijo

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