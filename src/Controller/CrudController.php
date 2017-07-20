<?php

namespace Virtualmed\Controller;

use Virtualmed\Manager\Manager;

class CrudController extends Controller
{
    /**
     * @return array
     */
    public function indexAction()
    {
        return $this->manager->findAll($this->entityName);
    }

    /**
     * @return array
     */
    public function postAction()
    {
        $entity = new $this->entityName($this->request->json());
        $this->manager->persist($entity);

        return $entity;
    }

    public function patchAction()
    {

    }

    /**
     * @return array
     */
    public function deleteAction()
    {
        $id = $this->request->query('id');
        $entity = $this->manager->findOne($this->entityName, ['_id' => new \MongoId($id)]);
        $this->manager->remove($entity);

        return $entity;
    }
}
