<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

$path = explode('/', $_SERVER['QUERY_STRING']);

$controllerName = $path[1] . "Controller";
$actionName = $path[2] . "Action";

$params = array_splice($path, 3);

require_once 'controllers/' . $controllerName . '.php';

$controller = new $controllerName($params);
$controller->$actionName();


