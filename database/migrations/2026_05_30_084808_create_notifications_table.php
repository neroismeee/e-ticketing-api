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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->string('title', 200);
            $table->text('message');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->string('ticket_id')->nullable();
            $table->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->nullOnDelete();
            $table->foreignId('downtime_id')
                ->nullable()
                ->constrained('downtime_records')
                ->nullOnDelete();
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->string('action_url', 500)->nullable();
            $table->string('priority', 50);

            // Index
            $table->index('user_id');
            $table->index('is_read');
            $table->index('created_at');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
