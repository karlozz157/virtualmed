<?php

namespace Virtualmed\Http;

class Router
{
    /**
     * @const string
     */
    const ARROBA = '@';

    /**
     * @const int
     */
    const CONTROLLER = 0;
    const ACTION     = 1;

    /**
     * @param string $pathName
     * @param string $controllerAndAction
     */
    public static function route($pathName, $controllerAndAction)
    {   
        $path = $_SERVER['PATH_INFO'];

        if ($path !== $pathName) {
            return;
        }

        $exploded = explode(self::ARROBA, $controllerAndAction);
        $controllerName = $exploded[self::CONTROLLER];
        $actionName = $exploded[self::ACTION];

        static::dispatch($controllerName, $actionName);
    }

    /**
     * @param string $controllerName
     * @param string $actionName
     */
    protected static function dispatch($controllerName, $actionName)
    {
        $controller = sprintf('Virtualmed\\Controller\\%sController', ucfirst($controllerName));

        if (!class_exists($controller)) {
            throw new \Exception(sprintf('The %s controller doesnt\'t exist!', $controllerName));
        }

        $controller = new $controller();
        $action = sprintf('%sAction', $actionName);

        if (!method_exists($controller, $action)) {
            throw new \Exception(sprintf('The %s controller doesn\'t have the %s action!', $controller, $action));
        }

        $response = $controller->$action();
        $controller->getResponse()->json($response);
    }
}
