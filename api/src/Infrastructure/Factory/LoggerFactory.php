<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

class LoggerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{
         *      stderr:bool,
         *      file?:string,
         *      debug:bool
         * } $config
         */
        $config = $container->get('config')['logger'];

        $level = $config['debug'] ? Logger::DEBUG : Logger::INFO;

        $log = new Logger('API');

        if ($config['stderr']) {
            $log->pushHandler(new StreamHandler('php://stderr', $level));
        }

        if (!empty($config['file'])) {
            $log->pushHandler(new StreamHandler($config['file'], $level));
        }

        return $log;
    }
}
