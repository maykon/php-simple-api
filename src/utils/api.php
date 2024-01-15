<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

function executeAPI($controllerName)
{
  $controllerClass = new ReflectionClass($controllerName);
  $controller = $controllerClass->newInstance();
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  switch ($requestMethod) {
    case "GET":
      $controller->list();
      break;
    case "POST":
      $controller->create();
      break;
    case "PUT":
      $controller->update();
      break;
    case "DELETE":
      $controller->delete();
      break;
    default:
      $controller->notAllowed();
  }
}
?>