<?php
require_once __DIR__ . "/utils/api.php";
require_once __DIR__ . "/controllers/topicController.php";
require_once __DIR__ . "/controllers/movieController.php";

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$routes = [
  "/api/topics" => TopicController::class,
  "/api/movies" => MovieController::class,
];

if (!array_key_exists($uri, $routes)) {
  http_response_code(404);
  echo json_encode(["message" => "Route Not Found!"]);
  die();
}

executeAPI($routes[$uri]);
