<?php

namespace Virtualmed\Entity;

abstract class AbstractEntity
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->mapper($data);
    }

    /**
     * @param array $data
     */
    public function mapper(array $data)
    {
        $methods = get_class_methods($this);

        foreach ($data as $key => $value) {
            $setter = sprintf('set%s', ucfirst($key));

            if (in_array($key, ['_id']) || !in_array($setter, $methods)) {
                continue;
            }

            $this->$setter($value);
        }

        $this->id = (isset($data['_id']) && $data['_id'] instanceof \MongoId) ? $data['_id']->__toString() : (  isset($data['id']) ? $data['id'] : '');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $methods = get_class_methods($this);
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();
        $data = [];

        foreach ($properties as $property) {
            $propertyKey = $property->name;
            $getter = sprintf('get%s', ucfirst($propertyKey));

            if (!in_array($getter, $methods)) {
                continue;
            }

            $data[$propertyKey] = $this->$getter();
        }

        return $data;
    }
}
