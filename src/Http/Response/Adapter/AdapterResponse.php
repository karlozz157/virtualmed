<?php

namespace Virtualmed\Http\Response\Adapter;

use Virtualmed\Http\Response\ResponseInterface;

abstract class AdapterResponse implements ResponseInterface
{
    /**
     * @var array $headers
     */
    protected $headers = [];

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * @param mixed $data
     */
    public function sendResponse($data)
    {
        $this->dispatchHeaders();
        $this->dispatchResponse($data);
        exit;
    }

    protected function dispatchHeaders()
    {
        foreach ($this->headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value), false);
        }
    }

    /**
     * @param mixed $data
     */
    abstract protected function dispatchResponse($data);
}
