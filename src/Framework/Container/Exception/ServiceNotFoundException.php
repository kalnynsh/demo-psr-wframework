<?php

namespace Framework\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends \InvalidArgumentException implements NotFoundExceptionInterface
{ }
