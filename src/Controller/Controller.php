<?php

namespace Virtualmed\Controller;

use Virtualmed\Http\Request;
use Virtualmed\Manager\Manager;

abstract class Controller
{
    /**
     * @const string
     */
    const CLASS_MANAGER = 'Virtualmed\\Manager\\%sManager';
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
    private $manager;

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $class = end(explode('\\', get_class($this)));
        $this->class = str_replace('Controller', '', $class);
        $this->entityName = 'Virtualmed\\Entity\\' . $this->class;
        $this->request = $request;
    }

    /**
     * @return Manager
     */
    protected function getManager()
    {
        if (!is_null($this->manager)) {
            return $this->manager;
        }

        $entityManager = sprintf(self::CLASS_MANAGER, $this->class);
        $manager = class_exists($entityManager) ? $entityManager : self::DEFAULT_MANAGER;
        $this->manager = new $manager();

        return $this->manager;
    }
}
