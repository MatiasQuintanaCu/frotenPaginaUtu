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

    // Consulta para obtener todos los posts con información del autor
    $sql = "SELECT 
                p.id_post,
                p.titulo,
                p.contenido,
                p.fecha_publicacion,
                p.img,
                p.id_autor,
                u.nombre as autor_nombre
            FROM posts p
            INNER JOIN usuarios u ON p.id_autor = u.id_usuario
            ORDER BY p.fecha_publicacion DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $posts = [];

    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Formatear cada post
            $post = [
                "id" => $row['id_post'],
                "titulo" => $row['titulo'],
                "contenido" => $row['contenido'],
                "fecha_publicacion" => $row['fecha_publicacion'],
                "autor" => [
                    "id" => $row['id_autor'],
                    "nombre" => $row['autor_nombre']
                ]
            ];

            // Agregar imagen solo si existe
            if (!empty($row['img'])) {
                $post["imagen"] = $row['img'];
            }

            $posts[] = $post;
        }

        sendSuccess($posts, "Posts obtenidos correctamente");
    } else {
        sendSuccess([], "No hay posts disponibles");
    }

} catch (PDOException $e) {
    error_log("Error PDO en get_posts.php: " . $e->getMessage());
    sendError("Error de base de datos: " . $e->getMessage());
} catch (Exception $e) {
    error_log("Error general en get_posts.php: " . $e->getMessage());
    sendError("Error del servidor: " . $e->getMessage());
}