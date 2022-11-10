<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use DevCoder\DotEnv;

require __DIR__ . '/vendor/autoload.php';

$absolutePathToEnvFile = __DIR__ . '/.env';

(new DotEnv($absolutePathToEnvFile))->load();

$isDevMode = !(getenv('APP_ENV') && getenv('APP_ENV') === 'production');

// the connection configuration
$dbParams = [
    'driver'   => 'pdo_mysql',
    'user'     => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASSWORD'),
    'dbname'   => getenv('MYSQL_DATABASE'),
    'host'     => getenv('MYSQL_HOST'),
];
$config        = ORMSetup::createAnnotationMetadataConfiguration(['common/Entities/'], $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);