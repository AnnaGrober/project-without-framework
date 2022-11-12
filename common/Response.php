<?php

namespace Common;

use Symfony\Component\HttpFoundation\Response as BaseResponse;

class Response
{
    /**
     * @throws \JsonException
     */
    public function __construct(array $data, int $code = 200)
    {
        $response = new BaseResponse();
        $response->setStatusCode($code);
        $response->setCharset('UTF-8');
        $response->setContent(json_encode([
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
        $response->send();
    }

}