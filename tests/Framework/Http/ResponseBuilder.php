<?php

namespace Test\Framework\Http;

use Framework\Http\Response;

class ResponseBuilder
{
    private Response $response;

    public function withBody(string $body): self
    {
        if ($this->response === null) {
            $this->response = new Response($body);
            return $this;
        }
        
        $new = $this->response->withBody($body);

        $this->response = $new;

        return $this;
    }

    public function withStatus(string $statusCode, $reasonePhrase = ''): self
    {
        $new = $this
            ->response
            ->withStatus($statusCode, $reasonePhrase);
        
        $this->response = $new;

        return $this;
    }

    public function withHeader(string $headerName, string $headerValue): self
    {
        $new = $this
            ->response
            ->withHeader($headerName, $headerValue);
        
        $this->response = $new;

        return $this;
    }

    public function build(): Response
    {
        return $this->response;
    }
}
