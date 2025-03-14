<?php

namespace Kolirt\Telegram\Core\Types;

/**
 * @see https://core.telegram.org/bots/api#contact
 */
class ContactType extends BaseType
{

    public function __construct(
        public string      $phone_number,
        public string      $first_name,
        public string|null $last_name = null,
        public int|null    $user_id = null,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            phone_number: $data['phone_number'],
            first_name: $data['first_name'],
            last_name: $data['last_name'] ?? null,
            user_id: $data['user_id'],
        );
    }
}
