<?php
session_start();

// URLs de redirección (ajusta según tu proyecto)
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

// 1. VERIFICAR MÉTODO HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirigir_con_mensaje($login_url, 'error', 'Método no permitido.');
}

include_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();
$logger = new Logger($db);

if (!$db) {
    redirigir_con_mensaje($login_url, 'error', 'Error de servicio. Inténtalo de nuevo más tarde.');
}

// 4. VALIDAR DATOS DE ENTRADA
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (empty($email) || empty($password)) {
    redirigir_con_mensaje($login_url, 'error', 'Por favor ingresa tu correo y contraseña.');
}

// Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirigir_con_mensaje($login_url, 'error', 'El formato del correo electrónico no es válido.');
}

// 5. BUSCAR USUARIO EN LA BASE DE DATOS
try {
    $query = "SELECT id, primer_nombre, email, password_hash, rol, activo FROM usuarios WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $email_sanitized = htmlspecialchars(strip_tags($email));
    $stmt->bindParam(':email', $email_sanitized);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar si el usuario está activo (opcional)
        if (isset($row['activo']) && $row['activo'] == 0) {
            $log_data = json_encode(['status' => 'inactive_user', 'email' => $email]);
            $logger->log('login_attempt', $log_data);
            redirigir_con_mensaje($login_url, 'error', 'Tu cuenta está desactivada. Contacta al administrador.');
        }

        // 6. VERIFICAR CONTRASEÑA
        if (password_verify($password, $row['password_hash'])) {
            // ---- LOGIN EXITOSO ----
            session_regenerate_id(true);

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['primer_nombre'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_rol'] = $row['rol'];
            $_SESSION['logged_in'] = true;

            // Actualizar último login (opcional)
            $update_query = "UPDATE usuarios SET ultimo_login = NOW() WHERE id = :id";
            $update_stmt = $db->prepare($update_query);
            $update_stmt->bindParam(':id', $row['id']);
            $update_stmt->execute();

            // Log de éxito
            $log_data = json_encode([
                'status' => 'success',
                'user_id' => $row['id'],
                'email' => $email,
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
            ]);
            $logger->log('login_attempt', $log_data);

            redirigir_con_mensaje($home_url, 'success', '¡Bienvenido de nuevo, ' . htmlspecialchars($row['primer_nombre']) . '!');
        }
    }

    // ---- CREDENCIALES INVÁLIDAS ----
    $log_data = json_encode([
        'status' => 'failure',
        'detail' => 'Invalid credentials',
        'email' => $email,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ]);
    $logger->log('login_attempt', $log_data);

    redirigir_con_mensaje($login_url, 'error', 'Credenciales incorrectas. Verifica tu correo y contraseña.');

} catch (PDOException $exception) {
    // ---- ERROR DE BASE DE DATOS ----
    $log_data = json_encode([
        'status' => 'exception',
        'detail' => $exception->getMessage(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine()
    ]);
    $logger->log('login_error', $log_data);

    redirigir_con_mensaje($login_url, 'error', 'Ocurrió un error inesperado. Por favor intenta de nuevo.');
}
?>