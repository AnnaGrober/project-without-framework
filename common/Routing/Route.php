<?php

namespace Common\Routing;

use DI\Container;
use Exceptions\Data\NotFoundException;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class Route
{

    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        try {
            $request = Request::createFromGlobals();
            $method  = strtolower($request->getMethod());

            $router = new Router($arguments);

            if ($name !== $method || !preg_match($router->getMask(), $request->getRequestUri())) {
                return;
            }

            $factory = $this->container->get(RouteFactory::class);
            $factory->setRequest($request);
            $factory->setControllerName($arguments[1]);
            $factory->setMethodName($arguments[2]);
            $factory->setRouter($router);

            return $factory->build();
        } catch (\Exception $e) {
            throw $e;
        }
    }

}