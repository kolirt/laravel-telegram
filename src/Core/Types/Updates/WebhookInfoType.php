<?php

namespace Kolirt\Telegram\Core\Types\Updates;

use Kolirt\Telegram\Core\Types\BaseType;

/**
 * @see https://core.telegram.org/bots/api#webhookinfo
 */
class WebhookInfoType extends BaseType
{

    public function __construct(
        public string      $url,
        public bool|null   $has_custom_certificate = null,
        public int|null    $pending_update_count = null,
        public string|null $ip_address = null,
        public int|null    $last_error_date = null,
        public string|null $last_error_message = null,
        public int|null    $last_synchronization_error_date = null,
        public int|null    $max_connections = null,
        public array|null  $allowed_updates = null,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            url: $data['url'],
            has_custom_certificate: $data['has_custom_certificate'] ?? null,
            pending_update_count: $data['pending_update_count'] ?? null,
            ip_address: $data['ip_address'] ?? null,
            last_error_date: $data['last_error_date'] ?? null,
            last_error_message: $data['last_error_message'] ?? null,
            last_synchronization_error_date: $data['last_synchronization_error_date'] ?? null,
            max_connections: $data['max_connections'] ?? null,
            allowed_updates: $data['allowed_updates'] ?? null,
        );
    }
}
