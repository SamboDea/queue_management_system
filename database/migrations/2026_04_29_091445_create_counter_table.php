<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counters', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                         // e.g. "Counter 1"
            $table->string('code');                                         // e.g. "C1"
            $table->enum('status', ['active', 'busy', 'closed'])->default('closed');
            $table->string('current_ticket')->nullable();                   // ticket being served now
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counters');
    }
};