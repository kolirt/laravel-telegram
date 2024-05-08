<?php

namespace Kolirt\Telegram\Core\Types;

use ReflectionClass;

abstract class BaseType
{
    abstract static function from(array $data): self;

}
