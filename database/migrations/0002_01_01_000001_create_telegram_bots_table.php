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
    }

    public function down(): void
    {
        Schema::dropIfExists(config('telegram.models.bot.table_name'));
    }
};
