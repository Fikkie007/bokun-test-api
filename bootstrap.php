<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

/** @var Dotenv $dotenv */
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$dotenv->required(['ACCESS_KEY', 'SECRET_KEY', 'APP_URL'])->notEmpty();

function env(string $key): string
{
    return $_SERVER[$key] ?? throw new RuntimeException("Missing ENV var: $key");
}
