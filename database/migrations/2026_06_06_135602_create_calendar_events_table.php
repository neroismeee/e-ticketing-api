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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->timestamp('start');
            $table->timestamp('end');
            $table->string('type', 50);
            $table->text('description')->nullable();
            $table->string('color', 50);
            $table->boolean('all_day')->default(false);
            $table->string('recurring_frequency', 50)->nullable();
            $table->integer('recurring_interval')->nullable();
            $table->timestamp('recurring_end_date')->nullable();
            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();

            // Index
            $table->index('start');
            $table->index('end');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_events');
    }
};
