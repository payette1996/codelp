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
                header("Content-Type: application/json");
                if ($parameter) {
                    $user = UserController::getUser($parameter);
                    if ($user) {
                        http_response_code(200);
                        echo $user->json();
                    } else {
                        http_response_code(404);
                    }

                } else {
                    $userCount = UserController::getCount();
                    echo json_encode($userCount);
                }
                break;
            case "POST":
                $json = file_get_contents("php://input");
                $data = json_decode($json, true);
                $user = new User($data);
                $status = UserController::register($user);
                $status ? http_response_code(201) : http_response_code(400);
                header("Content-Type: application/json");
                echo json_encode($status);
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
                $threadCount = ThreadController::getCount();
                echo json_encode($threadCount);
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
                $postCount = PostController::getCount();
                echo json_encode($postCount);
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