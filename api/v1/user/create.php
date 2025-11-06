<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Habilitar errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivos necesarios - RUTA CORREGIDA
include_once __DIR__ . '/../config/database.php';

function sendError($message, $code = 500) {
    http_response_code($code);
    echo json_encode(["error" => $message]);
    exit;
}

try {
    // Verificar método
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendError("Método no permitido", 405);
    }

    // Obtener datos JSON
    $input = file_get_contents("php://input");
    if (empty($input)) {
        sendError("No se recibieron datos", 400);
    }

    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        sendError("JSON inválido: " . json_last_error_msg(), 400);
    }

    // Validar campos requeridos
    if (empty($data['nombre']) || empty($data['correo']) || empty($data['contrasena'])) {
        sendError("Faltan datos obligatorios: nombre, correo o contraseña", 400);
    }

    // Sanitizar y validar
    $nombre = trim($data['nombre']);
    $correo = trim($data['correo']);
    $contrasena = $data['contrasena'];

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        sendError("Correo electrónico inválido", 400);
    }

    if (strlen($contrasena) < 6) {
        sendError("La contraseña debe tener al menos 6 caracteres", 400);
    }

    // Conectar a la base de datos
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        sendError("No se puede conectar a la base de datos", 503);
    }

    // Verificar si el correo ya existe
    $check_sql = "SELECT `id_usuario` FROM `usuarios` WHERE `correo` = :correo";
    $check_stmt = $db->prepare($check_sql);
    $check_stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        sendError("El correo ya está registrado", 409);
    }

    // Hash de la contraseña
    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $insert_sql = "INSERT INTO `usuarios`(`nombre`, `correo`, `contrasena`, `rol`) 
                   VALUES (:nombre, :correo, :contrasena, :rol)";
    
    $insert_stmt = $db->prepare($insert_sql);
    $insert_stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $insert_stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $insert_stmt->bindParam(':contrasena', $hashed_password, PDO::PARAM_STR);
    $insert_stmt->bindValue(':rol', 'usuario', PDO::PARAM_STR);

    if ($insert_stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Usuario registrado correctamente",
            "id_usuario" => $db->lastInsertId()
        ]);
    } else {
        throw new Exception("Error al ejecutar la inserción");
    }

} catch (PDOException $e) {
    error_log("Error PDO en create.php: " . $e->getMessage());
    sendError("Error de base de datos: " . $e->getMessage());
} catch (Exception $e) {
    error_log("Error general en create.php: " . $e->getMessage());
    sendError("Error del servidor: " . $e->getMessage());
}