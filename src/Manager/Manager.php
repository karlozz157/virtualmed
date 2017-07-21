<?php

namespace Virtualmed\Manager;

use Virtualmed\Entity\AbstractEntity;
use Virtualmed\Manager\Adapter\MongoManager;

class Manager implements ManagerInterface
{
    /**
     * @var ManagerInterface $manager
     */
    protected $manager;

    public function __construct()
    {
        $manager = sprintf('%s\\%s', __NAMESPACE__, Config::getParam('manager'));

        if (!class_exists($manager)) {
            throw new \Exception(sprintf('Lo siento el manager %s no existe!', $manager));
        }

        $this->manager = new $manager();
    }

    /**
     * @override
     */
    public function findOne($entityName, array $criteria = [])
    {
        if (!class_exists($entityName)) {
            throw new \Exception(sprintf('Class %s doesn\'t exist!', $entityName));
        }

        return $this->manager->findOne($entityName, $criteria);
    }

    /**
     * @override
     */
    public function findAll($entityName, array $criteria = [])
    {
        if (!class_exists($entityName)) {
            throw new \Exception(sprintf('Class %s doesn\'t exist!', $entityName));
        }

        return $this->manager->findAll($entityName, $criteria);
    }

    /**
     * @override
     */
    public function persist(AbstractEntity $entity)
    {
        $this->manager->persist($entity);
    }

    /**
     * @override
     */
    public function update(AbstractEntity $entity)
    {
        $this->manager->update($entity);
    }

    /**
     * @override
     */
    public function remove(AbstractEntity $entity)
    {
        $this->manager->remove($entity);
    }
}
