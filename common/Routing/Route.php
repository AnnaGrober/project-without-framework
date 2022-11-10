<?php

namespace Common\Routing;

use Exceptions\Data\NotFoundException;
use Symfony\Component\HttpFoundation\Request;

/**
 *
 */
class Route
{

    /**
     * @param $name
     * @param $arguments
     *
     * @return void
     */
    public function __call($name, $arguments)
    {
        $request = Request::createFromGlobals();
        $method  = strtolower($request->getMethod());
        $url     = $request->getRequestUri();
        $router  = new Router($arguments);

        if ($name !== $method || !preg_match($router->getMask(), $url)) {
            return;
        }

        $controllerName = $arguments[1];

        if (!class_exists($controllerName)) {
            throw new NotFoundException($controllerName . ' is undefined class name', 404);
        }
        $controller = new $controllerName();
        $methodName = $arguments[2];
        if (!method_exists($controller, $methodName)) {
            throw new NotFoundException($methodName . ' is undefined method in ' . $controllerName, 404);
        }
        $rm                 = new \ReflectionMethod($controllerName, $methodName);
        $params             = [];
        $paramsToController = [];
        preg_match_all($router->getMask(), $url, $params);

        foreach ($router->getParams() as $key => $param) {
            $paramsToController[$param] = $params[$key + 1][0];
        }

        return $rm->invokeArgs($controller, $paramsToController);
    }

}