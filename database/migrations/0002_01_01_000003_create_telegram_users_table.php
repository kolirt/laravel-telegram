<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(config('telegram.models.user.table_name'), function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique();

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
    }

    public function down(): void
    {
        Schema::dropIfExists(config('telegram.models.user.table_name'));
    }
};
