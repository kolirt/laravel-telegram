<?php

namespace Kolirt\Telegram;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Kolirt\Telegram\Core\Telegram;
use Kolirt\Telegram\Core\Types\Updates\UpdateType;
use Kolirt\Telegram\Facades\Config;

class TelegramController
{

    public function index(Request $request, $token)
    {
        $bot_model = Cache::remember('telegram:bot_' . $token, config('telegram.models.bot.cache_time'), function () use ($token) {
            $bots = config('telegram.models.bot.model')::get();
            return $bots->first(function ($bot) use ($token) {
                return $bot->token == $token;
            });
        });

        if ($bot_model) {
            if ($bot = Config::getBot($bot_model->name)) {
                $telegram = new Telegram($bot_model->token);

                if ($update = $this->getUpdate($request, $telegram)) {
                    $telegram->setUpdate($update);

                    $bot->setModel($bot_model);
                    $bot->run($telegram);
                }
            }

            return response()->json(['ok' => true]);
        }

        abort(404);
    }

    private function getUpdate(Request $request, Telegram $telegram): UpdateType|null
    {
        if ($request->has('update_id')) {
            return UpdateType::from($request->all());
        } else {
            $updates = $telegram->getUpdates(offset: -1, limit: 1);
            return $updates->ok && count($updates->result) ? $updates->result[0] : null;
        }
    }

}
