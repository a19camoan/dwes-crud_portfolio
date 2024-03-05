<?php
    use App\Core\Router;
    use App\Controllers\UsuariosController;
    use App\Controllers\AuthController;

    require_once "../bootstrap.php";

    session_start();

    if (!isset($_SESSION["perfil"])) {
        $_SESSION["perfil"] = "invitado";
    }

    $router = new Router();
    $router->add(
        [
            "name" => "home",
            "path" => "/^\/$/",
            "action" => [UsuariosController::class, "indexAction"],
            "auth" => ["invitado", "usuario"]
        ]
    );
    $router->add([
        "name" => "search",
        "path" => "/^\/search\?q=.+$/",
        "action" => [UsuariosController::class, "searchAction"],
        "auth" => ["invitado","usuario"]
    ]);
    $router->add([
        "name" => "searchEmpty",
        "path" => "/^\/search\?q=$/",
        "action" => [UsuariosController::class, "indexAction"],
        "auth" => ["invitado","usuario"]
    ]);
    $router->add(
        [
            "name" => "login",
            "path" => "/^\/login$/",
            "action" => [AuthController::class, "loginAction"],
            "auth" => ["invitado", "usuario"]
        ]
    );
    $router->add(
        [
            "name" => "logout",
            "path" => "/^\/logout$/",
            "action" => [AuthController::class, "logoutAction"],
            "auth" => ["invitado", "usuario"]
        ]
    );
    $router->add(
        [
            "name" => "deleteAccount",
            "path" => "/^\/delete$/",
            "action" => [UsuariosController::class, "deleteAccountAction"],
            "auth" => ["usuario"]
        ]
    );
    $router->add(
        [
            "name" => "register",
            "path" => "/^\/register$/",
            "action" => [AuthController::class, "createAccountAction"],
            "auth" => ["invitado", "usuario"]
        ]
    );
    $router->add(
        [
            "name" => "visibility",
            "path" => "/^\/visibility$/",
            "action" => [UsuariosController::class, "visibilityAction"],
            "auth" => ["usuario"]
        ]
    );
    $router->add(
        [
            "name" => "detailView",
            "path" => "/^\/detail\?q=\d+$/",
            "action" => [UsuariosController::class, "detailAction"],
            "auth" => ["invitado", "usuario"]
        ]
    );
    $router->add(
        [
            "name" => "activate",
            "path" => "/^\/activate\?token=.+$/",
            "action" => [AuthController::class, "activateAction"],
            "auth" => ["invitado", "usuario"]
        ]
    );
    $router->add(
        [
            "name" => "addAction",
            "path" => "/^\/edit$/",
            "action" => [UsuariosController::class, "addAction"],
            "auth" => ["usuario"]
        ]
    );
    $router->add(
        [
            "name" => "deleteAction",
            "path" => "/^\/del_data$/",
            "action" => [UsuariosController::class, "deleteAction"],
            "auth" => ["usuario"]
        ]
    );
    $router->add(
        [
            "name" => "editAction",
            "path" => "/^\/edit_data$/",
            "action" => [UsuariosController::class, "editAction"],
            "auth" => ["usuario"]
        ]
    );

    $request = $_SERVER["REQUEST_URI"];
    $route = $router->match($request);

    if ($route) {
        if (in_array($_SESSION["perfil"], $route["auth"])) {
            $className = $route["action"][0];
            $classMethod = $route["action"][1];
            $object = new $className;
            $object->$classMethod($request);
        } else {
            include_once "../app/Views/403_view.php";
        }
    } else {
        include_once "../app/Views/404_view.php";
    }
