<?php

namespace Virtualmed\Manager;

use Virtualmed\Entity\AbstractEntity;

interface ManagerInterface
{
    /**
     * @param string $entityName
     * @param array  $criteria
     *
     * @return AbstractEntity
     */
    public function findOne($entityName, array $criteria = []);

    /**
     * @param string $entityName
     * @param array  $criteria
     *
     * @return AbstractEntity[]
     */
    public function findAll($entityName, array $criteria = []);

    /**
     * @param AbstractEntity $entity
     */
    public function persist(AbstractEntity $entity);

    /**
     * @param AbstractEntity $entity
     */
    public function update(AbstractEntity $entity);

    /**
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity);
}
