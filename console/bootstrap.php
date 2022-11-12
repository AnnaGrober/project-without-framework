<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use DevCoder\DotEnv;

require __DIR__ . '/../vendor/autoload.php';

$absolutePathToEnvFile = __DIR__ . '/../.env';

(new DotEnv($absolutePathToEnvFile))->load();

$isDevMode = !(getenv('APP_ENV') && getenv('APP_ENV') === 'production');
$config    = new \Common\Config($_ENV);

$entityManager = EntityManager::create($config->get('db'), ORMSetup::createAnnotationMetadataConfiguration(['common/Entities/'], $isDevMode));


