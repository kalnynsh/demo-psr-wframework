<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\EmptyResponse;

class BasicAuthMiddleware
{
    public const ATTRIBUTE = '_user';
    private $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (! empty($username) && ! empty($password)) {

            foreach ($this->users as $existsUsername => $existsPassword) {

                if ($username === $existsUsername && $password === $existsPassword) {
                    return $next($request->withAttribute(self::ATTRIBUTE, $username));
                }

            }

        }

        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
    }
}
