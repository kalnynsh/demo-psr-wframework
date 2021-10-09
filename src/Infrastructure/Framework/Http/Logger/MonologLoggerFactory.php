<?php

namespace Infrastructure\Framework\Http\Logger;

use Psr\Container\ContainerInterface;

class MonologLoggerFactory
{
    public function __invoke(
        ContainerInterface $container,
        string $requestedName,
        ?array $options = null
    ) {
         /** @var \Monolog\Logger $logger */
         $logger = new \Monolog\Logger('App');

         $level = $container->get('config')['debug'] ? \Monolog\Logger::DEBUG : \Monolog\Logger::WARNING;

        //  $streamFile = dirname(__DIR__, 4) . '/var/logs/runtime/application.log';
         $streamFile = 'var/logs/runtime/application.log';


         $logger->pushHandler(new \Monolog\Handler\StreamHandler(
             $streamFile,
             $level
         ));

         return $logger;
    }
}
