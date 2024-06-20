<?php

namespace Kolirt\Telegram\Core\Types\Commands;

use Kolirt\Telegram\Core\Types\BaseType;

/**
 * @see https://core.telegram.org/bots/api#botcommand
 */
class BotCommandType extends BaseType
{

    public function __construct(
        public string $command,
        public string $description
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            $data['command'],
            $data['description']
        );
    }

}
