<?php


namespace App\Http\Middleware;


use Dflydev\FigCookies\Cookies;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookies;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CookiesMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach (Cookies::fromRequest($request)->getAll() as $cookie) {
            $request = FigRequestCookies::set(
                $request,
                $cookie
            );
        }

        $response = $handler->handle($request);

        foreach (SetCookies::fromResponse($response)->getAll() as $set_cookie) {
            $response = FigResponseCookies::set(
                $response,
                $set_cookie
            );
        }

        return $response;
    }
}
