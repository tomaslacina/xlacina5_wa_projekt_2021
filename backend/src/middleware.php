<?php

use Slim\App;

return function (App $app) {
    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "path" => "/auth",
        "secret" => ["TOKEN_KEY"]
    ]));
};