<?php
// api/index.php - VERSIÓN DE DEPURACIÓN

/*
 * PASO 1: Forzar la visualización de TODOS los errores de PHP.
 * Si hay un error de sintaxis o cualquier otro problema, esto lo mostrará en pantalla.
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Establecemos las cabeceras al principio para que los mensajes de depuración se vean como JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


/*
 * PASO 2: Verificar que el router recibe el parámetro 'request' desde .htaccess.
 */
$request_uri = $_GET['request'] ?? null;
if ($request_uri === null) {
    http_response_code(500);
    // Si ves este mensaje, significa que .htaccess no está pasando el parámetro correctamente.
    die(json_encode(["error" => "El router de la API no recibió el parámetro 'request'."]));
}


// Procesamos las variables como antes
$parts = explode('/', filter_var(rtrim($request_uri, '/'), FILTER_SANITIZE_URL));
$apiVersion = array_shift($parts);
$resource = array_shift($parts) ?? null;
$action = array_shift($parts) ?? null;


/*
 * PASO 3: Verificar qué valores tienen las variables.
 * Descomenta la siguiente línea para detener el script aquí y ver qué se ha procesado.
 * Para la URL /api/lalla, deberías ver: {"version_recibida":"v1","recurso_recibido":"lalla","accion_recibida":null}
 */
// die(json_encode(['version_recibida' => $apiVersion, 'recurso_recibido' => $resource, 'accion_recibida' => $action]));

switch ($apiVersion) {
    case 'v1':
        switch ($resource) {
            case 'core':
                // Lógica para el recurso 'core'
                switch ($action) {
                    case 'logger':
                        require_once __DIR__ . '/v1/core/logger.php';
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(["error" => "Acción no encontrada para el recurso 'core'."]);
                        break;
                }
                break;
                
            case 'config':
                // Lógica para el recurso 'config'
                switch ($action) {
                    case 'database':
                        require_once __DIR__ . '/v1/config/database.php';
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(["error" => "Acción no encontrada para el recurso 'config'."]);
                        break;
                }
                break; 
            case 'user':
                // Lógica para el recurso 'user'
                switch ($action) {
                    case 'login':
                        require_once __DIR__ . '/v1/user/login.php';
                        break;
                    case 'logout':
                        require_once __DIR__ . '/v1/user/logout.php';
                        break;
                    case 'create':
                        require_once __DIR__ . '/v1/user/create.php';
                        break;
                    case 'validate_session':
                        require_once __DIR__ . '/v1/user/validate_session.php';
                        break;
                    case 'user_session_data':
                        require_once __DIR__ . '/v1/user/get_user_session_data.php';
                        break;
                    case 'user_utils':
                        require_once __DIR__ . '/v1/user/utils.php';
                        break;
                    default:
                        http_response_code(404);
                        echo json_encode(["error" => "Acción no encontrada para el recurso 'user'."]);
                        break;
                }
                      break;
            
            break;

            default:
                // Si el recurso no existe dentro de la v1 (este es el caso para 'lalla')
                http_response_code(404);
                echo json_encode(["error" => "Recurso no encontrado en la API v1."]);
                break;
        }
        break;

    default:
        // Si la versión de la API no es 'v1'
        http_response_code(404);
        echo json_encode(["error" => "La versión de la API solicitada no es válida."]);
        break;
}
?>