<?php

namespace Kolirt\Telegram\Config\Keyboard\Buttons\Types;

use Kolirt\Telegram\Core\Enums\ChatTypeEnum;
use Kolirt\Telegram\Core\Types\BaseType;

/**
 * @see https://core.telegram.org/bots/api#chat
 */
class WebAppInfoType extends BaseType
{

    public function __construct(
        public int          $id,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            id: $data['id'],
        );
    }
}
