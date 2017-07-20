<?php

namespace Virtualmed\Http;

use Virtualmed\Entity\AbstractEntity;

class Response
{
    /**
     * @param mixed $data
     */
    public function json($data)
    {
        header('Content-type: application/json');

        $results = [];

        if ($data instanceof AbstractEntity) {
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
        exit;
    }
}
