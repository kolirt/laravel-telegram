<?php

namespace Kolirt\Telegram\Core\Types;

/**
 * @see https://core.telegram.org/bots/api#linkpreviewoptions
 */
class LinkPreviewOptionsType extends BaseType
{

    public function __construct(
        public bool|null   $is_disabled = null,
        public string|null $url = null,
        public bool|null   $prefer_small_media = null,
        public bool|null   $prefer_large_media = null,
        public bool|null   $show_above_text = null,
    )
    {
    }

    static function from(array $data): self
    {
        return new self(
            is_disabled: $data['is_disabled'] ?? null,
            url: $data['url'] ?? null,
            prefer_small_media: $data['prefer_small_media'] ?? null,
            prefer_large_media: $data['prefer_large_media'] ?? null,
            show_above_text: $data['show_above_text'] ?? null,
        );
    }
}
