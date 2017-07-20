<?php

namespace Virtualmed\Manager\Adapter;

use Virtualmed\Entity\AbstractEntity;
use Virtualmed\Manager\ManagerInterface;
use Virtualmed\Utils\Config;

class MongoManager extends AdapterManager implements ManagerInterface
{
    /**
     * @var \MongoDB $mongoDb
     */
    protected $mongoDb;

    public function __construct()
    {
        $username = Config::getParam('mongo_username');
        $password = Config::getParam('mongo_password');
        $dbname   = Config::getParam('mongo_database');

        $cdn = 'mongodb://localhost';

        if (!empty($username) && !empty($password)) {
            $cdn = sprintf('mongodb://%s:%s@localhost:27017/%s', $username, $password, $dbname);
        }

        $mongoClient = new \MongoClient($cdn);
        $this->mongoDb = $mongoClient->$dbname;
    }

    /**
     * @override
     */
    public function findOne($entityName, array $criteria = [])
    {
        $collectionName = $this->getClassFromEntityName($entityName);
        $document = $this->mongoDb->$collectionName->findOne($criteria);
        $entity = new $entityName($document);

        return $entity;
    }

    /**
     * @override
     */
    public function findAll($entityName, array $criteria = [])
    {
        $collectionName = $this->getClassFromEntityName($entityName);
        $documents = $this->mongoDb->$collectionName->find($criteria);
        $entities = [];

        foreach ($documents as $document) {
            $entities[] = new $entityName($document);
        }

        return $entities;
    }

    /**
     * @override
     */
    public function persist(AbstractEntity $entity)
    {
        $collectionName = $this->getClassFromEntity($entity);
        $data = $entity->toArray();
        $this->mongoDb->$collectionName->insert($data);
        $entity->mapper($data);
    }

    /**
     * @override
     */
    public function update(AbstractEntity $entity)
    {

    }

    /**
     * @override
     */
    public function remove(AbstractEntity $entity)
    {
        $collectionName = $this->getClassFromEntity($entity);
        $this->mongoDb->$collectionName->remove(['_id' => new \MongoId($entity->getId())]);
    }
}
