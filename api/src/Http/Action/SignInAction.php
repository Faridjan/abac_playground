<?php

declare(strict_types=1);


namespace App\Http\Action;

use App\Http\EmptyResponse;
use App\Http\JsonResponse;
use Proxy\OAuth\Action\LoginAction;
use Proxy\OAuth\Action\Type\PasswordType;
use Proxy\OAuth\Action\Type\UsernameType;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;
use Proxy\OAuth\Interfaces\HttpClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SignInAction implements RequestHandlerInterface
{

    private ConverterInterface $converter;
    private ConfigStoreInterface $configStore;

    public function __construct(
        ConverterInterface $converter,
        ConfigStoreInterface $configStore
    ) {
        $this->converter = $converter;
        $this->configStore = $configStore;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $authAction = new LoginAction($this->converter, $this->configStore);

        $username = new UsernameType($request->getParsedBody()['username'] ?? '');
        $password = new PasswordType($request->getParsedBody()['password'] ?? '');

        $tokenString = $authAction->login($username, $password);

        return (new jsonResponse(['Hello']))->withHeader('Set-Cookie', $tokenString);
    }
}