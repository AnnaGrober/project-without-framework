<?php

namespace Common\Routing;

use DI\Container;
use DI\DependencyException;
use Exceptions\Data\NotFoundException;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class RouteFactory
{

    private Container $container;
    private Request $request;
    private string $controllerName;
    private string $methodName;
    private Router $router;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws \ReflectionException
     * @throws DependencyException
     * @throws \DI\NotFoundException
     */
    public function build()
    {
        if (!class_exists($this->controllerName)) {
            throw new NotFoundException($this->controllerName . ' is undefined class name', 404);
        }

        $controller = $this->container->get($this->controllerName);
        if (!method_exists($controller, $this->methodName)) {
            throw new NotFoundException($this->methodName . ' is undefined method in ' . $this->controllerName, 404);
        }
        $rm                 = new \ReflectionMethod($this->controllerName, $this->methodName);
        $params             = [];
        $paramsToController = [$this->request];
        preg_match_all($this->router->getMask(), $this->request->getRequestUri(), $params);

        foreach ($this->router->getParams() as $key => $param) {
            $paramsToController[$param] = $params[$key + 1][0];
        }

        return $rm->invokeArgs($controller, $paramsToController);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @param string $controllerName
     *
     * @return $this
     */
    public function setControllerName(string $controllerName)
    {
        $this->controllerName = $controllerName;

        return $this;
    }

    /**
     * @param string $methodName
     *
     * @return $this
     */
    public function setMethodName(string $methodName)
    {
        $this->methodName = $methodName;

        return $this;
    }

    /**
     * @param Router $router
     *
     * @return $this
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;

        return $this;
    }

}