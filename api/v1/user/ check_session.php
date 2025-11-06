<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

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

// Verificar si el usuario está logueado
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    sendJsonResponse(true, "Sesión activa", [
        "user" => [
            "id" => $_SESSION['user_id'],
            "nombre" => $_SESSION['user_name'],
            "email" => $_SESSION['user_email'],
            "rol" => $_SESSION['user_rol']
        ]
    ]);
} else {
    sendJsonResponse(false, "No hay sesión activa");
}