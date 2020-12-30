<?php

declare(strict_types=1);

use App\Helper\JWTConverter;
use Proxy\OAuth\Helpers\DotEnvConfigStorage;
use Proxy\OAuth\Interfaces\ConfigStoreInterface;
use Proxy\OAuth\Interfaces\ConverterInterface;

return [
    ConverterInterface::class => function () {
        return new JWTConverter();
    },
    ConfigStoreInterface::class => function () {
        $configsEnv = new DotEnvConfigStorage(__DIR__ . '/../../');
        $configsEnv->load();
        return $configsEnv;
    },
];