<?php

namespace App\Http\Middleware;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BasicAuthMiddleware implements MiddlewareInterface
{
    public const ATTRIBUTE = '_user';
    private $users;
    private $responsePrototype;

    public function __construct(array $users, ResponseInterface $responsePrototype)
    {
        $this->users = $users;
        $this->responsePrototype = $responsePrototype;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        /** @var string|null $username */
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;

        /** @var string|null $password */
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;


        if (! empty($username) && ! empty($password)) {

            /**
             * @var string $existsUsername
             * @var string $existsPassword
             *
            */
            foreach ($this->users as $existsUsername => $existsPassword) {
                if ($username === $existsUsername && $password === $existsPassword) {
                    $requestWithAttr = $request->withAttribute(self::ATTRIBUTE, $username);
                    $response = $handler->handle($requestWithAttr);

                    return $response;
                }
            }
        }

        return $this
            ->responsePrototype
            ->withStatus(401)
            ->withHeader('WWW-Authenticate', 'Basic realm=Restricted area');
    }
}
