<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");


require_once __DIR__ . '/../../../Cofing/DbConect.php';


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
   http_response_code(200);
   exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   http_response_code(405);
   echo json_encode(["error" => "Método no permitido"]);
   exit;
}


$data = json_decode(file_get_contents("php://input"), true);


if (
   !isset($data['nombre']) ||
   !isset($data['correo']) ||
   !isset($data['contrasena'])
) {
   http_response_code(400);
   echo json_encode(["error" => "Faltan datos obligatorios"]);
   exit;
}


// 📦 Obtener conexión desde la clase Database
$database = new Database();
$conn = $database->getConnection();


try {
   // Verificar si el correo ya existe
   $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE correo = :correo");
   $check->execute([":correo" => $data['correo']]);
   if ($check->rowCount() > 0) {
       http_response_code(409);
       echo json_encode(["error" => "El correo ya está registrado"]);
       exit;
   }


   // Encriptar contraseña
   $hashed = password_hash($data['contrasena'], PASSWORD_DEFAULT);


   $sql = "INSERT INTO usuarios (nombre, correo, contrasena, rol)
           VALUES (:nombre, :correo, :contrasena, :rol)";
   $stmt = $conn->prepare($sql);
   $stmt->execute([
       ':nombre' => $data['nombre'],
       ':correo' => $data['correo'],
       ':contrasena' => $hashed,
       ':rol' => 'usuario'
   ]);


   http_response_code(201);
   echo json_encode([
       "message" => "Usuario registrado correctamente",
       "id_usuario" => $conn->lastInsertId()
   ]);


} catch (PDOException $e) {
   http_response_code(500);
   echo json_encode(["error" => "Error en la base de datos", "detalle" => $e->getMessage()]);
}





















