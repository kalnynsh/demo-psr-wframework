<?php

namespace Framework\Http;

class Response
{
    private array $headers = [];
    private string $body;
    private int $statusCode;
    private string $reasonPhrase = '';

    private static $PHRASES = [
        200 => 'OK',
        301 => 'Moved Permanently',
        400 => 'Bad Request',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    public function __construct(string $body = '', int $status = 200)
    {
        $this->body = $body;
        $this->statusCode = $status;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function withBody(string $body): self
    {
        $new = clone $this;
        $new->body = $body;

        return $new;
    }

    public function getReasonPhrase(): string
    {
        $this->checkReasonPhrase();

        return $this->reasonPhrase;
    }

    private function checkReasonPhrase(): void
    {
        $haveStatusCode = isset(self::$PHRASES[$this->statusCode]);

        if (!$this->reasonPhrase && $haveStatusCode) {
            $this->reasonPhrase = self::$PHRASES[$this->statusCode];
        }
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withStatus(int $code, string $reasonePhrase = ''): self
    {
        $new = clone $this;
        $new->statusCode = $code;
        $new->reasonPhrase = $reasonePhrase;

        return $new;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader(string $headerName): bool
    {
        return isset($this->headers[$headerName]);
    }

    public function getHeader(string $headerName): string|null
    {
        if (!$this->hasHeader($headerName)) {
            return null;
        }

        return $this->headers[$headerName];
    }

    public function withHeader(
        string $headerName, 
        string $headerValue
    ): self {
        $new = clone $this;

        if ($new->hasHeader($headerName)) {
            unset($new->headers[$headerName]);
        }

        $new->headers[$headerName] = $headerValue;

        return $new;
    }
}