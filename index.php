<?php

require __DIR__.'/vendor/autoload.php';
require_once __DIR__ . "/config/init.php";

use app\controllers\ClassifiedsController;
use app\database\ClassifiedsGateway;
use app\database\Db;
use app\ErrorHandler;

set_exception_handler("app\ErrorHandler::handleException");

header("Content-type:application/json; charset=UTF-8");

$parts = explode("/", $_SERVER['REQUEST_URI']);

$id = $parts[2] ?? null;

$database = new Db();
$gateway = new ClassifiedsGateway($database);

$controller = new ClassifiedsController($gateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id);
