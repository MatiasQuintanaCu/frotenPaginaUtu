<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Habilitar errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivos necesarios
include_once(__DIR__ . '/../config/database.php');


function sendError($message, $code = 500) {
    http_response_code($code);
    echo json_encode(["error" => $message]);
    exit;
}

function sendSuccess($data, $message = "Success") {
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

try {
    // Verificar método
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        sendError("Método no permitido", 405);
    }

    // Iniciar sesión
    session_start();

    // Verificar autenticación
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        sendError("No autorizado", 401);
    }

    // Conectar a la base de datos
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        sendError("No se puede conectar a la base de datos", 503);
    }

    $currentUserId = $_SESSION['user_id'];

    // Consulta para obtener usuarios DOCENTE y ADMIN
    $sql = "SELECT 
                id_usuario,
                nombre,
                correo,
                rol
            FROM usuarios 
            WHERE rol IN ('DOCENTE', 'ADMIN') 
            AND id_usuario != :current_user_id
            ORDER BY nombre ASC";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':current_user_id', $currentUserId);
    $stmt->execute();

    $usuarios = [];

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Formatear cada usuario
            $usuario = [
                "id" => $row['id_usuario'],
                "nombre" => $row['nombre'],
                "correo" => $row['correo'],
                "rol" => $row['rol']
            ];

            $usuarios[] = $usuario;
        }

        sendSuccess($usuarios, "Usuarios obtenidos correctamente");
    } else {
        sendSuccess([], "No hay usuarios disponibles");
    }

} catch (PDOException $e) {
    error_log("Error PDO en getUsers.php: " . $e->getMessage());
    sendError("Error de base de datos: " . $e->getMessage());
} catch (Exception $e) {
    error_log("Error general en getUsers.php: " . $e->getMessage());
    sendError("Error del servidor: " . $e->getMessage());
}
?>