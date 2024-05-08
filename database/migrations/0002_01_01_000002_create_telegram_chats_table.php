<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(config('telegram.models.chat.table_name'), function (Blueprint $table) {
            $table->bigInteger('id')->unique();

            $table->string('type');

            $table->string('title')->nullable();
            $table->string('username')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('telegram.models.chat.table_name'));
    }
};
