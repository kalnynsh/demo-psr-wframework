<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ServerRequestInterface;

class BasicAuthActionDecorator
{
    private $next;
    private $users;

    public function __construct(callable $next, array $users)
    {
        $this->next = $next;
        $this->users = $users;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (! empty($username) && ! empty($password)) {
            foreach ($this->users as $existsUsername => $existsPassword) {
                if ($username === $existsUsername && $password === $existsPassword) {
                    return ($this->next)($request->withAttribute('username', $username));
                }
            }
        }

        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
    }
}
