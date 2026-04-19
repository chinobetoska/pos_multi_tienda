<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| Configurado para Hostinger (PHP 8.2+, MySQL)
| Usar env-config.php para definir DB_HOST, DB_USER, DB_PASS, DB_NAME
| antes de cargar esta aplicación.
| -------------------------------------------------------------------
*/

// Cargar configuración de entorno si existe
if (file_exists(FCPATH . 'env-config.php')) {
    require_once FCPATH . 'env-config.php';
}

$db['default']['hostname'] = getenv('DB_HOST') ?: 'localhost';
$db['default']['username'] = getenv('DB_USER') ?: 'root';
$db['default']['password'] = getenv('DB_PASS') ?: '';
$db['default']['database'] = getenv('DB_NAME') ?: 'admin_mutltipos';

$db['default']['dbdriver'] = 'mysqli';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = false;
$db['default']['db_debug'] = false; // Deshabilitado en producción
$db['default']['cache_on'] = false;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8mb4'; // UTF8MB4 requerido por PHP 8 + MySQL moderno
$db['default']['dbcollat'] = 'utf8mb4_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['encrypt'] = false;
$db['default']['compress'] = false;
$db['default']['stricton'] = false;
$db['default']['failover'] = array();
$db['default']['save_queries'] = true;

$active_group = 'default';
$active_record = true;

/* End of file database.php */
