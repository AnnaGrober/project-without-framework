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

            return $this->container->get(RouteFactory::class)
                ->setRequest($request)
                ->setControllerName($arguments[1])
                ->setMethodName($arguments[2])
                ->setRouter($router)
                ->build();
        } catch (\Exception $e) {
            throw $e;
        }
    }

}