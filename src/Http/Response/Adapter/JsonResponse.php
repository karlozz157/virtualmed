<?php

namespace Virtualmed\Http\Response\Adapter;

use Virtualmed\Entity\AbstractEntity;

class JsonResponse extends AdapterResponse
{
    public function __construct()
    {
        $this->addHeader('Content-Type', 'application/json');
    }

    /**
     * @param mixed $data
     */
    public function dispatchResponse($data)
    {
        $results = [];

        if (!is_array($data)) {
            $results = [$data];
        } elseif ($data instanceof AbstractEntity) {
            $results = $data->toArray();
        } else {
            foreach ($data as $key => $entity) {
                if (is_object($entity) && method_exists($entity, 'toArray')) {
                    $results[] = $entity->toArray();
                } else {
                    $results[$key] = $entity;
                }
            }
        }

        echo json_encode($results);
    }
}
