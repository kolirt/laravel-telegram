<?php

namespace Kolirt\Telegram\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BotChatPivot extends Pivot
{

    protected $primaryKey = 'chat_id';

    protected $foreignKey = 'bot_id';
    protected $relatedKey = 'chat_id';

    protected $fillable = [
        'bot_id',
        'chat_id',
        'last_activity_at',
        'virtual_router_state'
    ];

    protected $casts = [
        'bot_id' => 'integer',
        'chat_id' => 'integer',
        'last_activity_at' => 'datetime'
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('telegram.models.bot_chat_pivot.table_name');
        parent::__construct($attributes);
    }

    protected function setKeysForSaveQuery($query): \Illuminate\Database\Eloquent\Builder
    {
        $query->where('bot_id', $this->bot_id);
        return parent::setKeysForSaveQuery($query);
    }

}
