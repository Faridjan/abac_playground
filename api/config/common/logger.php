<?php

declare(strict_types=1);

use App\Infrastructure\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

use function DI\factory;

return [
    LoggerInterface::class => factory(LoggerFactory::class),
    'config' => [
        'logger' => [
            'debug' => (bool)getenv('APP_DEBUG'),
            'file' => null,
            'stderr' => true
        ],
    ]
];
