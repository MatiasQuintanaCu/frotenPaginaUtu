<?php
session_start(); // ← Agregar al inicio

header('Access-Control-Allow-Origin: http://tu-dominio.com'); // Cambiar * por tu dominio específico
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true'); // ← IMPORTANTE para sesiones

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
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }

    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception('Error de conexión a la base de datos');
    }

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (empty($data['nombre']) || empty($data['descripcion']) || empty($data['fecha_evento'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
        exit;
    }

    // Obtener ID del usuario autenticado desde la sesión
    $id_creador = $_SESSION['user_id'] ?? $_SESSION['id_usuario'];

    $query = "INSERT INTO eventos (nombre, descripcion, fecha_evento, id_creador) 
              VALUES (:nombre, :descripcion, :fecha_evento, :id_creador)";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nombre', $data['nombre']);
    $stmt->bindParam(':descripcion', $data['descripcion']);
    $stmt->bindParam(':fecha_evento', $data['fecha_evento']);
    $stmt->bindParam(':id_creador', $id_creador, PDO::PARAM_INT);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Evento creado exitosamente',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        throw new Exception('Error al crear el evento');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
?>