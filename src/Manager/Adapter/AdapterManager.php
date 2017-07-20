<?php

namespace Virtualmed\Manager\Adapter;

use Virtualmed\Entity\AbstractEntity;

abstract class AdapterManager
{
    /**
     * @param AbstractEntity $entity
     *
     * @return string
     */
    protected function getClassFromEntity(AbstractEntity $entity)
    {
        $class = explode('\\', get_class($entity));

        return strtolower(end($class));
    }

    /**
     * @param string $entityName
     *
     * @return string
     */
    protected function getClassFromEntityName($entityName)
    {
        $class = explode('\\', $entityName);

        return strtolower(end($class));
    }
}
