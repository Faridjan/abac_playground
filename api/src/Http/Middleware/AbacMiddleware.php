<?php


namespace App\Http\Middleware;


use App\Http\JsonResponse;
use App\User;
use Casbin\Enforcer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AbacMiddleware implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $e = new Enforcer(__DIR__ . "/../../../model.conf", __DIR__ . "/../../../policy.csv");

        $subj = new User('Fred', 27);

        $sub = $subj; // the user that wants to access a resource.
        $obj = $request->getUri()->getPath(); // the resource that is going to be accessed.
        $act = $request->getMethod(); // the operation that the user performs on the resource.


        if ($e->enforce($sub, $obj, $act) === true) {
            return $handler->handle($request);
        } else {
            return new JsonResponse("Denied");
        }
    }
}