<?php

use PDash\Controller;

use GSpataro\Routing\Method;

return [
    "home" => [
        "path" => "/",
        "callback" => [Controller\HomeController::class, "index"]
    ],
    "error404" => [
        "path" => "/pageNotFound",
        "callback" => [Controller\HomeController::class, "pageNotFound"]
    ],
    "error405" => [
        "path" => "/methodNotAllowed",
        "callback" => [Controller\HomeController::class, "methodNotAllowed"]
    ]
];
