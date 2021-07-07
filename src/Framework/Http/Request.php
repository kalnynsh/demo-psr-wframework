<?php

namespace Framework\Http;

class Request
{
    private array $queryParams;
    private array|null $parsedBody;
   

    public function __construct($queryParams = [], $parsedBody = null)
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
    }   

    public function getQueryParams(): array
    {
        return $this->queryParams;
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
        return $this->parsedBody;
    }    
}
