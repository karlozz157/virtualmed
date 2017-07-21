<?php

namespace Virtualmed\Http;

use Virtualmed\Http\Response\Adapter\JsonResponse;
use Virtualmed\Http\Response\Response;
use Virtualmed\Http\Request;

class Router
{
    /**
     * @const string
     */
    const ARROBA = '@';
    const CONTROLLER_NAMESPACE = 'Virtualmed\\Controller';

    /**
     * @const int
     */
    const CONTROLLER = 0;
    const ACTION = 1;

    /**
     * @var Response $response
     */
    protected $response;

    public function __construct()
    {
        $this->response = new Response(new JsonResponse());
    }

    /**
     * @param string $route
     * @param string $resource
     */
    public function route($route, $resource)
    {
        $pathInfo = $_SERVER['PATH_INFO'];

        if ($pathInfo !== $route) {
            return;
        }

        $resource = explode(self::ARROBA, $resource);
        $this->dispatch($resource[self::CONTROLLER], $resource[self::ACTION]);
    }

    /**
     * @param string $controller
     * @param string $action
     */
    protected function dispatch($controller, $action)
    {
        $controller = sprintf('%s\\%s', self::CONTROLLER_NAMESPACE, ucfirst($controller));

        if (!$this->classExists($controller)) {
            throw new \Exception(sprintf('The %s doesnt\'t exist!', $controller));
        }

        if (!$this->actionExists($controller, $action)) {
            throw new \Exception(sprintf('The %s controller doesn\'t have %s action!', $controller, $action));
        }

        $controller = new $controller(new Request());
        $this->response->sendResponse($controller->$action());
    }

    /**
     * @param string $controller
     *
     * @return boolean
     */
    private function classExists($controller)
    {
        return in_array($controller, get_declared_classes())  || class_exists($controller);
    }

    /**
     * @param string $controller
     * @param string $action
     *
     * @return boolean
     */
    private function actionExists($controller, $action)
    {
        return in_array($action, get_class_methods($controller));
    }
}
