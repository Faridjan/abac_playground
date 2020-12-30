<?php

declare(strict_types=1);

use App\Infrastructure\Factory\Doctrine\ValidatorFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function DI\factory;

return array(
    ValidatorInterface::class => factory(ValidatorFactory::class)
);
