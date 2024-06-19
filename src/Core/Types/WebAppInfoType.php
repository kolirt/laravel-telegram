<?php

namespace Kolirt\Telegram\Core\Types;

class WebAppInfoType extends BaseType
{

    public function __construct(
        public string $url
    )
    {
    }

    static function from(array $data): BaseType
    {
        return new self(
            url: $data['url']
        );
    }
}
