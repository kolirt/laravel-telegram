<?php

namespace Kolirt\Telegram\Core\Types;

/**
 * @see https://core.telegram.org/bots/api#location
 */
class LocationType extends BaseType
{

    public function __construct(
        public float      $latitude,
        public float      $longitude,
        public float|null $horizontal_accuracy = null,
        public int|null   $live_period = null,
        public int|null   $heading = null,
        public int|null   $proximity_alert_radius = null,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            latitude: $data['latitude'],
            longitude: $data['longitude'],
            horizontal_accuracy: $data['horizontal_accuracy'] ?? null,
            live_period: $data['live_period'] ?? null,
            heading: $data['heading'] ?? null,
            proximity_alert_radius: $data['proximity_alert_radius'] ?? null,
        );
    }
}
