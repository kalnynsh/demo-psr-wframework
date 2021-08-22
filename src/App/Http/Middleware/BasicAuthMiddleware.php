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

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
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

        $response = new Response();

        return $response
            ->withStatus(401)
            ->withHeader('WWW-Authenticate', 'Basic realm=Restricted area');
    }
}
