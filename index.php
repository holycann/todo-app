<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');

require_once __DIR__ . '/src/core/Router.php';
require_once __DIR__ . '/src/routes/UserRoute.php';
require_once __DIR__ . '/src/routes/PagesRoute.php';
require_once __DIR__ . '/src/routes/AuthRoute.php';
require_once __DIR__ . '/src/routes/TaskRoute.php';
require_once __DIR__ . '/src/routes/ReminderRoute.php';

Router::dispatch();

?>