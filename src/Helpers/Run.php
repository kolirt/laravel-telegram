<?php

namespace Kolirt\Telegram\Helpers;

use ReflectionMethod;

class Run
{

    public function call($handler, $method, $input): void
    {
        $ref = new ReflectionMethod($handler, $method);
        $ref_params = $ref->getParameters();

        $params = [];
        foreach ($ref_params as $ref_param) {
            $type = $ref_param->getType();
            if ($type && class_exists($type->getName())) {
                $params[] = app($type->getName());
            } else {
                $params[] = $input;
            }
        }

        call_user_func([$handler, $method], ...$params);
    }

}
