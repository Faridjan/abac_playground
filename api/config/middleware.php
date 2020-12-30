<?php

declare(strict_types=1);

use App\Http\Middleware\CookiesMiddleware;
use App\Http\Middleware\DomainExceptionHandler;
use App\Http\Middleware\ValidationExceptionHandler;
use App\Http\Middleware\ClearEmptyInput;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $app) {
    $app->add(CookiesMiddleware::class);

    $app->add(ValidationExceptionHandler::class);
    $app->add(DomainExceptionHandler::class);

    $app->add(ClearEmptyInput::class);
    $app->addBodyParsingMiddleware();

    $app->add(ErrorMiddleware::class);
};
