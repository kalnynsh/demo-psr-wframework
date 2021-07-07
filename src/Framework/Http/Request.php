<?php

namespace Framework\Http;

class Request
{
    public function getQueryParams(): array
    {
        return $_GET;
    }

    /**
     * getParsedBody - return parsed body or null.
     * 
     * TODO *
     * For Json request: json decode body.
     * For Xml request: SimpleXml decode body.
     *
     * @return array|null
     */
    public function getParsedBody(): array|null
    {
        return $_POST ?: null;
    }

    /**
     * getBody - return body of HTTP request, like Json, xml
     *
     * @return string
     */
    public function getBody(): string
    {
        return file_get_contents('php://input');
    }

    public function getCookies(): array
    {
        return $_COOKIE;
    }

    public function getSession(): array
    {
        return $_SESSION;
    }

    public function getServer(): array
    {
        return $_SERVER;
    }
}
