<?php

declare(strict_types=1);

namespace App\ErrorHandler;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class LogErrorHandler extends ErrorHandler
{

    public function __construct(
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory,
        LoggerInterface $logger
    ) {
        parent::__construct($callableResolver, $responseFactory, $logger);
    }

    protected function writeToErrorLog(): void
    {
        $this->logger->error(
            $this->exception->getMessage(),
            [
                'exception' => $this->exception,
                'url' => (string)$this->request->getUri(),
            ]
        );
    }
}