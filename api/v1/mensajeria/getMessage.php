<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Activar logging temporalmente para debugging
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);

function sendJsonResponse($success, $message = "", $data = null) {
    if (ob_get_length()) ob_clean();
    
    $status = $success ? "success" : "error";
    http_response_code($success ? 200 : 400);
    
    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Verificar sesión PRIMERO
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    error_log("getMessages - Sesión no válida");
    sendJsonResponse(false, "No autorizado");
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    sendJsonResponse(false, "Método no permitido");
}

if (!isset($_GET['id_receptor']) || empty($_GET['id_receptor'])) {
    sendJsonResponse(false, "Falta el ID del receptor");
}

try {
    include_once(__DIR__ . '/../config/database.php');
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        sendJsonResponse(false, "Error de conexión a la base de datos");
    }

    $id_emisor = intval($_SESSION['user_id']);
    $id_receptor = intval($_GET['id_receptor']);

    error_log("DEBUG - User ID: $id_emisor, Receptor: $id_receptor");

    // CORREGIDO: Consulta SQL simplificada y correcta
    $sql = "SELECT 
                m.id_mensaje,
                m.id_emisor,
                m.id_receptor, 
                m.contenido,
                m.fecha_envio,
                u_emisor.nombre AS nombre_emisor
            FROM mensajes m
            INNER JOIN usuarios u_emisor ON m.id_emisor = u_emisor.id_usuario
            WHERE (m.id_emisor = :id_emisor AND m.id_receptor = :id_receptor)
               OR (m.id_emisor = :id_receptor AND m.id_receptor = :id_emisor)
            ORDER BY m.fecha_envio ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_emisor', $id_emisor, PDO::PARAM_INT);
    $stmt->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
    
    if (!$stmt->execute()) {
        $errorInfo = $stmt->errorInfo();
        error_log("getMessages - Error SQL: " . print_r($errorInfo, true));
        sendJsonResponse(false, "Error en la consulta SQL: " . $errorInfo[2]);
    }

    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("getMessages - Mensajes encontrados: " . count($mensajes));

    // Debug: mostrar primeros mensajes
    if (count($mensajes) > 0) {
        error_log("Primer mensaje: " . print_r($mensajes[0], true));
    }

    // Añadir campo es_mio
    foreach ($mensajes as &$msg) {
        $msg['es_mio'] = ($msg['id_emisor'] == $id_emisor);
    }

    sendJsonResponse(true, "Mensajes obtenidos correctamente", $mensajes);

} catch (Exception $e) { 
    error_log("getMessages - Exception: " . $e->getMessage());
    sendJsonResponse(false, "Error del servidor: " . $e->getMessage());
}
?>