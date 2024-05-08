<?php

namespace Kolirt\Telegram\Models;

use Illuminate\Database\Eloquent\Model;
use Kolirt\Telegram\Core\Enums\ChatTypeEnum;
use Kolirt\Telegram\Models\Pivots\BotChatPivot;
use Kolirt\MasterModel\MasterModel;

class TelegramChat extends Model
{
    use MasterModel;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'type'
    ];

    protected $casts = [
        'type' => ChatTypeEnum::class
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('telegram.models.chat.table_name');
        parent::__construct($attributes);
    }

    public function bots(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            config('telegram.models.bot.model'),
            config('telegram.models.bot_chat_pivot.table_name'),
            'chat_id',
            'bot_id'
        )->using(BotChatPivot::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(config('telegram.models.user.model'), 'chat_id', 'id');
    }

}
