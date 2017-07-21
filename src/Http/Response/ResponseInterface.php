<?php

namespace Virtualmed\Http\Response;

interface ResponseInterface
{
    /**
     * @param mixed $data
     */
    public function sendResponse($data);
}
