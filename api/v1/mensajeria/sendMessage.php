<?php
session_start();
header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

function sendJsonResponse($success, $message = "", $data = null, $code = 200) {
    http_response_code($code);
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    sendJsonResponse(false, "No autorizado", null, 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, "Método no permitido", null, 405);
}

try {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $id_receptor = $data['id_receptor'] ?? null;
    $contenido = trim($data['contenido'] ?? '');

    if (empty($id_receptor) || empty($contenido)) {
        sendJsonResponse(false, "Faltan datos requeridos");
    }

    include_once(__DIR__ . '/../config/database.php');

    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception("Error de conexión a la base de datos");
    }

    $id_emisor = $_SESSION['user_id'];

    // DEBUG: Log del envío
    error_log("DEBUG sendMessage - Emisor: $id_emisor, Receptor: $id_receptor, Contenido: $contenido");

    $sql = "INSERT INTO mensajes (id_emisor, id_receptor, contenido, fecha_envio) 
            VALUES (:id_emisor, :id_receptor, :contenido, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_emisor', $id_emisor, PDO::PARAM_INT);
    $stmt->bindParam(':id_receptor', $id_receptor, PDO::PARAM_INT);
    $stmt->bindParam(':contenido', $contenido);

    if ($stmt->execute()) {
        error_log("DEBUG sendMessage - Mensaje insertado correctamente, ID: " . $conn->lastInsertId());
        sendJsonResponse(true, "Mensaje enviado correctamente", [
            "id_mensaje" => $conn->lastInsertId(),
            "fecha_envio" => date('Y-m-d H:i:s')
        ]);
    } else {
        $errorInfo = $stmt->errorInfo();
        error_log("DEBUG sendMessage - Error al insertar: " . print_r($errorInfo, true));
        sendJsonResponse(false, "Error al enviar el mensaje: " . $errorInfo[2]);
    }

} catch (Exception $e) {
    error_log("Error en sendMessage: " . $e->getMessage());
    sendJsonResponse(false, "Error del servidor: " . $e->getMessage());
}
?>