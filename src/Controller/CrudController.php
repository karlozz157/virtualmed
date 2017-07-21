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
        return $this->getManager()->findAll($this->entityName);
    }

    /**
     * @return array
     */
    public function postAction()
    {
        $entity = new $this->entityName($this->request->json());
        $this->getManager()->persist($entity);

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
        $entity = $this->getManager()->findOne($this->entityName, ['_id' => new \MongoId($id)]);
        $this->getManager()->remove($entity);

        return $entity;
    }
}
