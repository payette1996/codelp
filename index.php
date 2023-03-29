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
                $status = UserController::postUser($user);
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
                header("Content-Type: application/json");
                if ($parameter) {
                    $thread = ThreadController::getThread($parameter);
                    if ($thread) {
                        http_response_code(200);
                        echo $thread->json();
                    } else {
                        http_response_code(404);
                    }
                } else {
                    $threadCount = ThreadController::getCount();
                    echo json_encode($threadCount);
                }
                break;
            case "Thread":
                $json = file_get_contents("php://input");
                $data = json_decode($json, true);
                $thread = new Thread($data);
                $status = ThreadController::postThread($thread);
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
    case "posts":
        switch ($method) {
            case "GET":
                header("Content-Type: application/json");
                if ($parameter) {
                    $post = PostController::getPost($parameter);
                    if ($post) {
                        http_response_code(200);
                        echo $post->json();
                    } else {
                        http_response_code(404);
                    }
                } else {
                    $postCount = PostController::getCount();
                    echo json_encode($postCount);
                }
                break;
            case "Post":
                $json = file_get_contents("php://input");
                $data = json_decode($json, true);
                $post = new Post($data);
                $status = PostController::postPost($post);
                $status ? http_response_code(201) : http_response_code(400);
                header("Content-Type: application/json");
                echo json_encode($status);
                break;
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