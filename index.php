<?php
// Archivo: public/index.php

// ------------------------------------------
// 1. CAPTURA Y LIMPIEZA DE LA RUTA
// ------------------------------------------

// Obtener la URI completa (ej: /tkts?status=open)
$request_uri_completa = $_SERVER['REQUEST_URI'];

// Eliminar cualquier parámetro de consulta después del '?'
$ruta_base = strtok($request_uri_completa, '?');

// Normalizar la ruta: quitar barras iniciales/finales (ej: '/tkts/' -> 'tkts')
$request_uri = trim($ruta_base, '/');

// ------------------------------------------
// 2. ENRUTAMIENTO (Mapeo de la URI a un archivo)
// ------------------------------------------

// Usa __DIR__ para garantizar que la ruta de inclusión sea ABSOLUTA y SEGURA.
// Asumimos que la carpeta 'views' está un nivel arriba, fuera de 'public'.

switch ($request_uri) {
    case '':
        // Carga la página de inicio
        require __DIR__  . '/pages/home.php';
        break;
    case 'home':
        // Carga la página de inicio
        require __DIR__  . '/pages/home.php';
        break;
    case 'register':
        // Lógica de Registro (idealmente llama a un Controlador)
        require __DIR__  . '/pages/register.php';
        break;
    case 'login':
        // Lógica de Login
        require __DIR__  . '/pages/login.php';
        break;
    case 'chat':
        // Página de Chat
        require __DIR__  . '/pages/chat.php';
        break;

    default:
        // Manejo de error 404
        http_response_code(404);
        require __DIR__  . '/views/404.php';
        break;
}
