<?php

namespace Kolirt\Telegram\Models;

use Illuminate\Database\Eloquent\Model;
use Kolirt\MasterModel\Traits\MasterModel;
use Kolirt\Telegram\Core\Methods\Updates\GetUpdatesMethod;

class Bot extends Model
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

    protected $hidden = [
        'token'
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
        )->using(config('telegram.models.bot_chat_pivot.model'))->withTimestamps();
    }

}
