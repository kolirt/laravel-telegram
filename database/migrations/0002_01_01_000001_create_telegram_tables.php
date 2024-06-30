<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(config('telegram.models.bot.table_name'), function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique()->index();

            $table->text('token')->nullable();

            $table->timestamps();
        });

        Schema::create(config('telegram.models.chat.table_name'), function (Blueprint $table) {
            $table->bigInteger('id')->unique()->primary();

            $table->string('type');

            $table->string('title')->nullable();
            $table->string('username')->nullable();

            $table->timestamps();
        });

        Schema::create(config('telegram.models.user.table_name'), function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique()->primary();

            $table->boolean('is_bot')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->boolean('is_premium')->nullable();

            $table->bigInteger('chat_id');
            $table->foreign('chat_id')
                ->references('id')
                ->on(config('telegram.models.chat.table_name'))
                ->cascadeOnDelete();

            $table->timestamps();
        });

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

            $table->text('virtual_router_state')->nullable();

            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            $table->primary(['bot_id', 'chat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('telegram.models.bot.table_name'));
        Schema::dropIfExists(config('telegram.models.chat.table_name'));
        Schema::dropIfExists(config('telegram.models.user.table_name'));
        Schema::dropIfExists(config('telegram.models.bot_chat_pivot.table_name'));
    }
};
