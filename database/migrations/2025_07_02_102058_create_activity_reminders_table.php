<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->enum('reminder_type', ['3_days', '30_minutes']);
            $table->timestamp('sent_at');
            $table->timestamps();
            
            // Prevent duplicate reminders for same activity and type
            $table->unique(['activity_id', 'reminder_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_reminders');
    }
};
