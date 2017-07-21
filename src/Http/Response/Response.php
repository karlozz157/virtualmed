<?php

namespace Virtualmed\Http\Response;

class Response implements ResponseInterface
{
    /**
     * @var ResponseInterface $response
     */
    protected $response;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @param mixed $data
     */
    public function sendResponse($data)
    {
        $this->response->sendResponse($data);
    }
}
