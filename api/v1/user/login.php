<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Habilitar errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Iniciar sesión para mantener el estado del usuario
session_start();

function sendJsonResponse($success, $message, $data = []) {
    http_response_code($success ? 200 : 400);
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJsonResponse(false, "Método no permitido");
}

// Obtener datos JSON
$input = file_get_contents("php://input");
if (empty($input)) {
    sendJsonResponse(false, "No se recibieron datos");
}

$data = json_decode($input, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    sendJsonResponse(false, "JSON inválido: " . json_last_error_msg());
}

$email = $data['email'] ?? null;
$password = $data['password'] ?? null;

if (empty($email) || empty($password)) {
    sendJsonResponse(false, "Por favor ingresa tu correo y contraseña");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendJsonResponse(false, "El formato del correo electrónico no es válido");
}

// Incluir y conectar a la base de datos
include_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    sendJsonResponse(false, "Error de servicio. Inténtalo de nuevo más tarde");
}

try {
    $query = "SELECT id_usuario, nombre, correo, contrasena, rol FROM usuarios WHERE correo = :correo LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':correo', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $row['contrasena'])) {
            // Configurar variables de sesión
            $_SESSION['user_id'] = $row['id_usuario'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_email'] = $row['correo'];
            $_SESSION['user_rol'] = $row['rol'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_time'] = time();

            // Configurar cookie de sesión (opcional, para mayor seguridad)
            session_regenerate_id(true);

            sendJsonResponse(true, "¡Bienvenido de nuevo, " . $row['nombre'] . "!", [
                "user" => [
                    "id" => $row['id_usuario'],
                    "nombre" => $row['nombre'],
                    "email" => $row['correo'],
                    "rol" => $row['rol']
                ],
                "redirect" => "home"
            ]);
        }
    }

    sendJsonResponse(false, "Credenciales incorrectas. Verifica tu correo y contraseña");

} catch (PDOException $exception) {
    error_log("Error en login: " . $exception->getMessage());
    sendJsonResponse(false, "Ocurrió un error inesperado. Por favor intenta de nuevo");
}