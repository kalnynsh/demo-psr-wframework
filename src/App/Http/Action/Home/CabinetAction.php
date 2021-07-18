<?php

namespace App\Http\Action\Home;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response\EmptyResponse;

class CabinetAction
{
    private $users;

    public function __construct(array $users)
    {
        $this->users = $users;
    }

    public function __invoke(ServerRequestInterface $request): Response
    {
        $givenUsername = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $givenPassword = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (! empty($givenUsername) && ! empty($givenPassword)) {
            foreach ($this->users as $havingUsername => $havingPassword) {
                if ($givenUsername === $havingUsername && $givenPassword === $havingPassword) {
                    return new HtmlResponse('Seccuss! You logged in as ' . $givenUsername);
                }
            }
        }

        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
    }
}
