<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number');                                    // e.g. "A047"
            $table->enum('category', ['A', 'B', 'C'])->default('A');           // A=General, B=Finance, C=VIP
            $table->enum('status', ['waiting', 'serving', 'done', 'skip'])->default('waiting');
            $table->foreignId('counter_id')->nullable()->constrained('counters')->onDelete('set null');
            $table->timestamp('called_at')->nullable();
            $table->timestamp('served_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};