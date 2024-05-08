<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(config('telegram.models.bot_chat_pivot.table_name'), function (Blueprint $table) {
            $table->unsignedBigInteger('bot_id');
            $table->foreign('bot_id')
                ->references('id')
                ->on(config('telegram.models.bot.table_name'))
                ->cascadeOnDelete();

            $table->bigInteger('chat_id');
            $table->foreign('chat_id')
                ->references('id')
                ->on(config('telegram.models.chat.table_name'))
                ->cascadeOnDelete();

            $table->primary(['bot_id', 'chat_id']);

            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('telegram.models.bot_chat_pivot.table_name'));
    }
};
