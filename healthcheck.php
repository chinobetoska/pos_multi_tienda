<?php
/**
 * Health Check — Verificar que el despliegue en Hostinger funciona
 * Acceder a: https://tu-dominio.com/healthcheck.php
 *
 * IMPORTANTE: Eliminar o proteger este archivo después de confirmar el despliegue
 */

header('Content-Type: application/json; charset=utf-8');

$checks = [];
$all_ok = true;

// PHP version
$php_version = PHP_VERSION;
$php_ok = version_compare($php_version, '8.2.0', '>=');
$checks['php'] = [
    'version' => $php_version,
    'required' => '>=8.2.0',
    'ok' => $php_ok,
];
if (!$php_ok) $all_ok = false;

// Extensiones requeridas
$required_ext = ['mysqli', 'mbstring', 'json', 'session', 'openssl'];
foreach ($required_ext as $ext) {
    $loaded = extension_loaded($ext);
    $checks['extension_' . $ext] = ['ok' => $loaded];
    if (!$loaded) $all_ok = false;
}

// Cargar env-config si existe
$env_file = __DIR__ . '/env-config.php';
if (file_exists($env_file)) {
    require_once $env_file;
    $checks['env_config'] = ['ok' => true, 'message' => 'env-config.php cargado'];
} else {
    $checks['env_config'] = ['ok' => false, 'message' => 'env-config.php no encontrado'];
    $all_ok = false;
}

// Conexión a base de datos
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: '';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: '';

if ($db_user && $db_name) {
    $conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        $checks['database'] = ['ok' => false, 'error' => $conn->connect_error];
        $all_ok = false;
    } else {
        $checks['database'] = ['ok' => true, 'host' => $db_host, 'database' => $db_name];
        $conn->close();
    }
} else {
    $checks['database'] = ['ok' => false, 'message' => 'Credenciales no configuradas en env-config.php'];
    $all_ok = false;
}

// Permisos de escritura
$writable_dirs = [
    'application/logs',
    'application/cache',
];
foreach ($writable_dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    $writable = is_writable($path);
    $checks['writable_' . str_replace('/', '_', $dir)] = ['ok' => $writable, 'path' => $path];
    if (!$writable) $all_ok = false;
}

// Resultado final
$response = [
    'status' => $all_ok ? 'ok' : 'error',
    'timestamp' => date('Y-m-d H:i:s'),
    'checks' => $checks,
];

http_response_code($all_ok ? 200 : 500);
echo json_encode($response, JSON_PRETTY_PRINT);
