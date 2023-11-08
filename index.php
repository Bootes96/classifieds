<?php

require __DIR__.'/vendor/autoload.php';
require_once __DIR__ . "/config/init.php";

use app\controllers\ClassifiedsController;
use app\database\ClassifiedsGateway;
use app\database\Db;
use app\ErrorHandler;

set_error_handler("app\ErrorHandler::handleError");
set_exception_handler("app\ErrorHandler::handleException");

header("Content-type:application/json; charset=UTF-8");

$parts = explode("/", $_SERVER['REQUEST_URI']);
$id = explode("?", $parts[2])[0] ?? null;

$fields = [];
parse_str($_SERVER['QUERY_STRING'], $fields);

$database = new Db();
$gateway = new ClassifiedsGateway($database);

$controller = new ClassifiedsController($gateway);
$controller->processRequest($_SERVER['REQUEST_METHOD'], $id, $fields);
