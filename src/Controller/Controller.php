<?php

namespace Virtualmed\Controller;

use Virtualmed\Http\Request;
use Virtualmed\Http\Response;
use Virtualmed\Manager\Manager;

abstract class Controller
{
    /**
     * @const string
     */
    const DEFAULT_MANAGER = 'Virtualmed\\Manager\\Manager';

    /**
     * @var string $class
     */
    protected $class;

    /**
     * @var string $entityName
     */
    protected $entityName;

    /**
     * @var Manager $manager
     */
    protected $manager;

    public function __construct()
    {
        $class = end(explode('\\', get_class($this)));
        $this->class = str_replace('Controller', '', $class);
        $this->entityName = 'Virtualmed\\Entity\\' . $this->class;
        $this->manager = $this->getManager();
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * @return Manager
     */
    private function getManager()
    {
        $entityManager = sprintf('Virtualmed\\Manager\\%sManager', $this->class);
        $manager = class_exists($entityManager) ? $entityManager : self::DEFAULT_MANAGER;

        return new $manager();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
