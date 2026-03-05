<?php

ini_set('display_errors', 1); //makes PHP display errors in the browser (useful for debugging).
ini_set('display_startup_errors', 1); //shows errors that happen even before the script starts running.
error_reporting(E_ALL); //sets the level to report every kind of error (notices, warnings, fatal errors).
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
