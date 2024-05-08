<?php

namespace Kolirt\Telegram\Models;

use Illuminate\Database\Eloquent\Model;
use Kolirt\MasterModel\MasterModel;
use Kolirt\Telegram\Core\Methods\Updates\GetUpdatesMethod;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;

class TelegramBot extends Model
{
    use MasterModel;

    use GetUpdatesMethod;

    protected $fillable = [
        'name',
        'token'
    ];

    protected $casts = [
        'token' => 'encrypted'
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('telegram.models.bot.table_name');
        parent::__construct($attributes);
    }

    public function chats(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            config('telegram.models.chat.model'),
            config('telegram.models.bot_chat_pivot.table_name'),
            'bot_id',
            'chat_id'
        )->using(BotChatPivot::class)->withTimestamps();
    }

}
