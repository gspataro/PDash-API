<?php

use PDash\Controller;
use PDash\Middleware;
use GSpataro\Routing\Method;

return [
    "home" => [
        "path" => "/",
        "callback" => [Controller\HomeController::class, "index"],
        "middlewares" => [Middleware\AuthMiddleware::class]
    ],
    "error404" => [
        "path" => "/pageNotFound",
        "callback" => [Controller\HomeController::class, "pageNotFound"]
    ],
    "error405" => [
        "path" => "/methodNotAllowed",
        "callback" => [Controller\HomeController::class, "methodNotAllowed"]
    ],
    "accessDenied" => [
        "path" => "/accessDenied",
        "callback" => [Controller\HomeController::class, "accessDenied"]
    ],

    "todo.list" => [
        "path" => "/todo/list",
        "callback" => [Controller\TodoController::class, "list"],
        "middlewares" => [Middleware\AuthMiddleware::class]
    ],
    "todo.insert" => [
        "path" => "/todo/insert",
        "callback" => [Controller\TodoController::class, "insert"],
        "methods" => [Method::POST]
    ],
    "todo.update" => [
        "path" => "/todo/update",
        "callback" => [Controller\TodoController::class, "update"],
        "methods" => [Method::PUT]
    ],
    "todo.delete" => [
        "path" => "/todo/delete",
        "callback" => [Controller\TodoController::class, "delete"],
        "methods" => [Method::DELETE]
    ]
];
