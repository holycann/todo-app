<?php

$env = require_once __DIR__ . '/env.php';

define('APP_NAME', $env['app_name']);
define('BASE_ENDPOINT', $env['base_endpoint']);
define('ASSETS_URL', $env['base_url'] . $env['base_endpoint'] . '/assets');
ini_set('session.gc_maxlifetime', 3600);

?>