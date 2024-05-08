<?php

namespace Kolirt\Telegram\Controllers;

use Illuminate\Support\Facades\Cache;
use Kolirt\Telegram\Config\Config;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Facades\Config as ConfigFacade;

class TelegramController
{

    public function index($token)
    {
        $bot_model = Cache::remember('telegram:bot_' . $token, config('telegram.models.bot.cache_time'), function () use ($token) {
            $bots = config('telegram.models.bot.model')::get();
            return $bots->first(function ($bot) use ($token) {
                return $bot->token == $token;
            });
        });

        if ($bot_model) {
            /**
             * @var Config $config
             */
            $config = ConfigFacade::getFacadeRoot();
            $config->load();

            $bot = $config->getBot($bot_model->name);
            if ($bot) {
                $telegram = new Telegram($bot_model->token);
                $updates = $telegram->getUpdates(offset: -1, limit: 1);

                if (count($updates)) {
                    $update = $updates[0];

                    $telegram->setUpdate($update);

                    $bot->setModel($bot_model);
                    $bot->run($telegram, $update);
                }

                return response()->json(['ok' => true]);
            }
        }

        abort(404);
    }

}
