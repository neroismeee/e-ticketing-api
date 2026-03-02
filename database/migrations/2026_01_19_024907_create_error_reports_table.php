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
        Schema::create('error_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('priority');
            $table->string('status');
            $table->foreignId('reporter_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('assigned_to_id')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('assigned_team')->nullable();
            $table->timestamp('date_reported');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->decimal('estimated_effort')->nullable();
            $table->decimal('actual_effort')->nullable();
            $table->decimal('sla_time_elapsed')->nullable();
            $table->decimal('sla_time_remaining')->nullable();
            $table->boolean('sla_breached')->default(false);
            $table->foreignId('source_ticket_id')
                  ->nullable()
                  ->constrained('tickets')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->boolean('is_direct_input')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error_reports');
    }
};
