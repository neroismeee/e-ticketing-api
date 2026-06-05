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
        Schema::create('merged_tickets', function (Blueprint $table) {
            $table->string('parent_ticket_id');
            $table->foreign('parent_ticket_id')
                ->references('id')
                ->on('tickets')
                ->cascadeOnDelete();
            $table->string('merged_ticket_id');
            $table->foreign('merged_ticket_id')
                ->references('id')
                ->on('tickets')
                ->cascadeOnDelete();
            $table->timestamp('merged_at')->useCurrent();
            $table->foreignId('merged_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->primary(['parent_ticket_id', 'merged_ticket_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merged_tickets');
    }
};
