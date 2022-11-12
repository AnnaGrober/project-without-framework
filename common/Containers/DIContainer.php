<?php

namespace Common\Containers;

use Common\Config;
use DevCoder\DotEnv;
use DI\Definition\Source\MutableDefinitionSource;
use DI\Proxy\ProxyFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Common\Routing\Route;
use DI\ContainerBuilder;
use DI\Container;

use function DI\create;

class DIContainer extends Container
{
    public function __construct(MutableDefinitionSource $definitionSource = null, ProxyFactory $proxyFactory = null, ContainerInterface $wrapperContainer = null)
    {
        parent::__construct($definitionSource, $proxyFactory, $wrapperContainer);
    }

    public function init()
    {
        $this->set(Config::class, create(Config::class)->constructor($_ENV));
        $this->set(EntityManager::class, fn(Config $config) => EntityManager::create(
            $config->get('db'),
            ORMSetup::createAnnotationMetadataConfiguration([__DIR__ . '/../Entities'])
        ));
    }
}