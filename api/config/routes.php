<?php

declare(strict_types=1);

use App\Http\Action\AbacTestAction;
use App\Http\Action\HomeAction;
use App\Http\Action\SignInAction;
use App\Http\Middleware\AbacMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app) {
    $app->get('/', HomeAction::class);

    $app->post('/login', SignInAction::class);

    $app->group(
        '/abac',
        function (RouteCollectorProxy $group) {
            $group->map(['GET', 'POST'], '/write', AbacTestAction::class);
        }
    )->add(AbacMiddleware::class);
};
