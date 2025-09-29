<?php

use Kolirt\Telegram\Models\Bot;
use Kolirt\Telegram\Models\Chat;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\Telegram\Models\User;

return [
    'api_endpoint' => 'https://api.telegram.org/bot',

    /**
     * Default parse mode for messages
     *
     * Available values: ParseModeEnum::HTML, ParseModeEnum::MARKDOWN, null
     */
    'default_parse_mode' => null,

    'models' => [
        'bot' => [
            'table_name' => 'telegram_bots',
            'cache_time' => now()->addMinutes(15),
            'model' => Bot::class
        ],
        'chat' => [
            'table_name' => 'telegram_chats',
            'model' => Chat::class,
        ],
        'bot_chat_pivot' => [
            'table_name' => 'telegram_bot_telegram_chat',
            'model' => BotChatPivot::class
        ],
        'user' => [
            'table_name' => 'telegram_users',
            'model' => User::class,
        ],
    ],

    'domain' => env('TELEGRAM_DOMAIN', env('APP_URL')),
    'webhook_path' => 'api/telegram/bot{token}',
    'disable_routes' => false,

    'config_files' => [
        base_path('telegram/test.php')
    ],

    'metadata_filename' => 'telegram.meta.php',
];
