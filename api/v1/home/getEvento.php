<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Habilitar errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivos necesarios
include_once __DIR__ . '/../config/database.php';

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

    // Conectar a la base de datos
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        sendError("No se puede conectar a la base de datos", 503);
    }

    // Consulta para obtener todos los eventos con información del creador
    $sql = "SELECT 
                e.id_evento,
                e.nombre,
                e.descripcion,
                e.fecha_evento,
                e.id_creador,
                u.nombre as creador_nombre
            FROM eventos e
            INNER JOIN usuarios u ON e.id_creador = u.id_usuario
            ORDER BY e.fecha_evento DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $eventos = [];

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Formatear cada evento
            $evento = [
                "id" => $row['id_evento'],
                "titulo" => $row['nombre'],
                "descripcion" => $row['descripcion'],
                "fecha_evento" => $row['fecha_evento'],
                "autor" => [
                    "id" => $row['id_creador'],
                    "nombre" => $row['creador_nombre']
                ]
            ];

            $eventos[] = $evento;
        }

        sendSuccess($eventos, "Eventos obtenidos correctamente");
    } else {
        sendSuccess([], "No hay eventos disponibles");
    }

} catch (PDOException $e) {
    error_log("Error PDO en get_eventos.php: " . $e->getMessage());
    sendError("Error de base de datos: " . $e->getMessage());
} catch (Exception $e) {
    error_log("Error general en get_eventos.php: " . $e->getMessage());
    sendError("Error del servidor: " . $e->getMessage());
}