<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./app/controllers/UserController.php";
require_once "./app/controllers/ThreadController.php";
require_once "./app/controllers/PostController.php";

$method = $_SERVER["REQUEST_METHOD"];

$uri = $_SERVER["REQUEST_URI"];
$sections = explode("/", $uri);
$endpoint = $sections[2] ?? null;
$parameter = $sections[3] ?? null;

$unserializedUser = isset($_SESSION["user"]) ? unserialize($_SESSION["user"]) : false;

try {
    switch ($endpoint) {
        case "auth":
            header("Content-Type: application/json");
            $json = file_get_contents("php://input");
            $data = json_decode($json, true);
            $user = UserController::auth($data["email"], $data["password"]);
            if ($user) {
                $user->setRawPassword($data["password"]);
                $response = [
                    "authenticated" => true,
                    "user" => $user->json(true)
                ];
                $_SESSION["user"] = serialize($user);
            } else {
                $response = ["authenticated" => false];
            }
            http_response_code(200);
            echo json_encode($response);
            break;
        case "session":
            switch ($method) {
                case "GET":
                    header("Content-Type: application/json");
                    http_response_code(200);
                    if ($unserializedUser) {
                        echo json_encode($unserializedUser->json(true));
                    } else {
                        echo json_encode(false);
                    }
                    break;
                case "POST":
                    header("Content-Type: application/json");
                    $_SESSION = array();
                    session_destroy();
                    http_response_code(204);
                    break;
            }

            break;
        case "users":
            switch ($method) {
                case "GET":
                    header("Content-Type: application/json");
                    if ($parameter && $parameter !== "count") {
                        $results = UserController::getUser($parameter);
                        if ($results) {
                            http_response_code(200);
                            echo json_encode($results);
                        } else {
                            http_response_code(404);
                            echo json_encode(false);
                        }
                    } elseif ($parameter === "count") {
                        $userCount = UserController::getCount();
                        http_response_code(200);
                        echo json_encode($userCount);
                    } else {
                        $users = UserController::getAll();
                        http_response_code(200);
                        echo json_encode($users);
                    }
                    break;
                case "POST":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    $user = new User($data);
                    $status = UserController::postUser($user);
                    $status ? http_response_code(201) : http_response_code(400);
                    echo json_encode($status);
                    break;
                case "PUT":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    $rawPassword = $data["user"]["password"];
                    $user = new User($data["user"]);
                    $email = $user->getEmail();
                    $new = new User($data["new"]);
                    if (UserController::auth($email, $rawPassword)) {
                        $status = UserController::putUser($user, $new);
                        $status ? http_response_code(201) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(403);
                        echo json_encode(false);
                    }
                    break;
                case "DELETE":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    $rawPassword = $data["password"];
                    $user = new User($data);
                    if (UserController::auth($user->getEmail(), $rawPassword)) {
                        $status = UserController::deleteUser($user);
                        $status ? http_response_code(204) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(403);
                        echo json_encode(false);
                    }
                    break;
            }
            break;
        case "threads":
            switch ($method) {
                case "GET":
                    header("Content-Type: application/json");
                    if ($parameter && $parameter !== "count") {
                        $thread = ThreadController::getThread($parameter);
                        if ($thread) {
                            http_response_code(200);
                            echo json_encode($thread);
                        } else {
                            http_response_code(404);
                            echo json_encode(false);
                        }
                    } elseif ($parameter === "count") {
                        $threadCount = ThreadController::getCount();
                        http_response_code(200);
                        echo json_encode($threadCount);
                    } else {
                        $threads = ThreadController::getAll();
                        http_response_code(200);
                        echo json_encode($threads);
                    }
                    break;
                case "POST":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    if (!$unserializedUser) {
                        $rawPassword = $data["user"]["password"];
                        $user = new User($data["user"]);
                    } else {
                        $rawPassword = $unserializedUser->getRawPassword();
                        $user = $unserializedUser;
                    }
                    $thread = isset($data["thread"]) ? new Thread($data["thread"]) : new Thread($data);
                    if (UserController::auth($user->getEmail(), $rawPassword)) {
                        $status = ThreadController::postThread($user, $thread);
                        $status ? http_response_code(201) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(200);
                        echo json_encode($user->getRawPassword());
                    }
                    break;
                case "PUT":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    $rawPassword = $data["user"]["password"];
                    $user = new User($data["user"]);
                    $thread = new Thread($data["thread"]);
                    $new = new Thread($data["new"]);
                    if (UserController::auth($user->getEmail(), $rawPassword)) {
                        $status = ThreadController::putThread($user, $thread, $new);
                        $status ? http_response_code(201) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(403);
                        echo json_encode(false);
                    }
                    break;
                case "DELETE":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    $rawPassword = $data["user"]["password"];
                    $user = new User($data["user"]);
                    $thread = new Thread($data["thread"]);
                    if (UserController::auth($user->getEmail(), $rawPassword)) {
                        $status = ThreadController::deleteThread($user, $thread);
                        $status ? http_response_code(204) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(403);
                        echo json_encode(false);
                    }
                    break;
            }
            break;
        case "posts":
            switch ($method) {
                case "GET":
                    header("Content-Type: application/json");
                    if ($parameter && $parameter !== "count") {
                        $post = PostController::getPost($parameter);
                        if ($post) {
                            http_response_code(200);
                            echo $post->json();
                        } else {
                            http_response_code(404);
                        }
                    } elseif ($parameter === "count") {
                        $postCount = PostController::getCount();
                        http_response_code(200);
                        echo json_encode($postCount);
                    } else {
                        $posts = PostController::getAll();
                        http_response_code(200);
                        echo json_encode($posts);
                    }
                    break;
                case "POST":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    if (!$unserializedUser) {
                        $rawPassword = $data["user"]["password"];
                        $user = new User($data["user"]);
                    } else {
                        $rawPassword = $unserializedUser->getRawPassword();
                        $user = $unserializedUser;
                    }
                    $post = isset($data) ? new Post($data) : new Post($data);
                    if (UserController::auth($user->getEmail(), $rawPassword)) {
                        $status = PostController::postPost($user, $post);
                        $status ? http_response_code(201) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(403);
                        return false;
                    }
                    break;
                case "PUT":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    $rawPassword = $data["user"]["password"];
                    $user = new User($data["user"]);
                    $post = new Post($data["post"]);
                    $new = new Post($data["new"]);
                    if (UserController::auth($user->getEmail(), $rawPassword)) {
                        $status = PostController::putPost($user, $post, $new);
                        $status ? http_response_code(201) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(403);
                        echo json_encode(false);
                    }
                    break;
                case "DELETE":
                    header("Content-Type: application/json");
                    $json = file_get_contents("php://input");
                    $data = json_decode($json, true);
                    $rawPassword = $data["user"]["password"];
                    $user = new User($data["user"]);
                    $post = new Post($data["post"]);
                    if (UserController::auth($user->getEmail(), $rawPassword)) {
                        $status = PostController::deletePost($user, $post);
                        $status ? http_response_code(204) : http_response_code(400);
                        echo json_encode($status);
                    } else {
                        http_response_code(403);
                        echo json_encode(false);
                    }
                    break;
            }
            break;
        default:
            require_once "./app/views/app.html";
            break;
    }
} catch (Throwable $e) {
    header("Content-Type: application/json");
    http_response_code(400);
    echo($e);
}
?>