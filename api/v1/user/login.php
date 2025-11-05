<?php
session_start();

$login_url = '/login.php';
$home_url = '/dashboard.php';

function redirigir_con_mensaje($url, $tipo, $texto) {
    $_SESSION['flash_message'] = [
        'type' => $tipo,
        'text' => $texto
    ];
    header("Location: " . $url);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir_con_mensaje($login_url, 'error', 'Método no permitido.');
}

include_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    redirigir_con_mensaje($login_url, 'error', 'Error de servicio. Inténtalo de nuevo más tarde.');
}

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || empty($password)) {
    redirigir_con_mensaje($login_url, 'error', 'Por favor ingresa tu correo y contraseña.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirigir_con_mensaje($login_url, 'error', 'El formato del correo electrónico no es válido.');
}

try {
    $query = "SELECT id_usuario, nombre, correo, contraseña, rol FROM usuarios WHERE correo = :correo LIMIT 1";
    $stmt = $db->prepare($query);
    $email_sanitized = htmlspecialchars(strip_tags($email));
    $stmt->bindParam(':correo', $email_sanitized);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $row['contraseña'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $row['id_usuario'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_email'] = $row['correo'];
            $_SESSION['user_rol'] = $row['rol'];
            $_SESSION['logged_in'] = true;

            redirigir_con_mensaje($home_url, 'success', '¡Bienvenido de nuevo, ' . htmlspecialchars($row['nombre']) . '!');
        }
    }

    redirigir_con_mensaje($login_url, 'error', 'Credenciales incorrectas. Verifica tu correo y contraseña.');

} catch (PDOException $exception) {
    redirigir_con_mensaje($login_url, 'error', 'Ocurrió un error inesperado. Por favor intenta de nuevo.');
}
?>