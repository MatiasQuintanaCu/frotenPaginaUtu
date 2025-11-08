<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once(__DIR__ . '/../config/database.php');

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit;
}

$currentUserId = $_SESSION['user_id'];
$database = new Database();
$db = $database->getConnection();

$query = "
    SELECT DISTINCT 
        u.id_usuario AS id,
        u.nombre,
        u.rol
    FROM usuarios u
    INNER JOIN mensajes m 
        ON (m.id_emisor = u.id_usuario OR m.id_receptor = u.id_usuario)
    WHERE :currentUserId IN (m.id_emisor, m.id_receptor)
    AND u.id_usuario != :currentUserId
    ORDER BY u.nombre ASC
";

$stmt = $db->prepare($query);
$stmt->bindParam(':currentUserId', $currentUserId);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "status" => "success",
    "data" => $users
]);
