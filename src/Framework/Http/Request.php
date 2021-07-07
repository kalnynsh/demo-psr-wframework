<?php

namespace Framework\Http;

class Request
{
    private array $queryParams = [];
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

    public function withQueryParams(array $query): self
    {
        $new = clone $this;
        $new->queryParams = $query;

        return $new;
    }

    public function getParsedBody(): array|null
    {
        return $this->parsedBody;
    }
    
    public function withParsedBody(array $dataBody): self
    {
        $new = clone $this;
        $new->parsedBody = $dataBody;

        return $new;
    }    
}
