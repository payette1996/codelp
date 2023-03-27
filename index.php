<?php
require_once "./app/controllers/UserController.php";
require_once "./app/controllers/ThreadController.php";
require_once "./app/controllers/PostController.php";

$method = $_SERVER["REQUEST_METHOD"];

$uri = $_SERVER["REQUEST_URI"];
$sections = explode("/", $uri);
$endpoint = $sections[2] ?? null;
$parameter = $sections[3] ?? null;

switch ($endpoint) {
    case "users":
        switch ($method) {
            case "GET":
                http_response_code(200);
                header("Content-Type: application/json");
                break;
            case "POST":
                http_response_code(201);
                header("Content-Type: application/json");
                break;
            case "PUT":
                http_response_code(200);
                header("Content-Type: application/json");
                break;
            case "DELETE":
                http_response_code(204);
                header("Content-Type: application/json");
                break;
        }
        break;
    case "threads":
        switch ($method) {
            case "GET":
                http_response_code(200);
                header("Content-Type: application/json");
                break;
            case "POST":
                http_response_code(201);
                header("Content-Type: application/json");
                break;
            case "PUT":
                http_response_code(200);
                header("Content-Type: application/json");
                break;
            case "DELETE":
                http_response_code(204);
                header("Content-Type: application/json");
                break;
        }
        break;
    case "posts":
        switch ($method) {
            case "GET":
                http_response_code(200);
                header("Content-Type: application/json");
                break;
            case "POST":
                http_response_code(201);
                header("Content-Type: application/json");
                break;
            case "PUT":
                http_response_code(200);
                header("Content-Type: application/json");
                break;
            case "DELETE":
                http_response_code(204);
                header("Content-Type: application/json");
                break;
        }
        break;
    default:
        require_once "./app/views/app.html";
        break;
}
?>