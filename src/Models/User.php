<?php

namespace Kolirt\Telegram\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Kolirt\MasterModel\Traits\MasterModel;

class User extends Authenticatable
{
    use MasterModel;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'is_bot',
        'first_name',
        'last_name',
        'username',
        'is_premium',
        'chat_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'is_bot' => 'boolean',
        'is_premium' => 'boolean',
        'chat_id' => 'integer'
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('telegram.models.user.table_name');
        parent::__construct($attributes);
    }

    public function chat(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(config('telegram.models.chat.model'), 'chat_id', 'id');
    }

}
