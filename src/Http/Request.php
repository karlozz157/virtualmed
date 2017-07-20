<?php

namespace Virtualmed\Http;

class Request
{
    /**
     * @return array
     */
    public function json()
    {
        return json_decode(file_get_contents("php://input"), true);
    }

    /**
     * @param string $key
     * @param string $defaultValue
     *
     * @return array|mixed
     */
    public function query($key = null, $defaultValue = '')
    {
        return $this->getData($_GET, $key, $defaultValue);
    }

    /**
     * @param string $key
     * @param string $defaultValue
     *
     * @return array|mixed
     */
    public function request($key = null, $defaultValue = '')
    {
        return $this->getData($_POST, $key, $defaultValue);
    }

    /**
     * @param array  $data
     * @param string $key
     * @param string $defaultValue
     *
     * @return array|mixed
     */
    protected function getData(array $data = [], $key = null, $defaultValue = '')
    {
        return ($key) ? (isset($data[$key]) ? $data[$key] : $defaultValue) : $data;
    }
}
