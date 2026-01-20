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
            $table->id()->primary();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('priority');
            $table->string('status');
            $table->string('reporter_id');
            $table->string('assigned_to_id')->nullable();
            $table->string('assigned_team')->nullable();
            $table->timestamp('date_reported');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->decimal('estimated_effort')->nullable();
            $table->decimal('actual_effort')->nullable();
            $table->decimal('sla_time_elapsed')->nullable();
            $table->decimal('sla_time_remaining')->nullable();
            $table->boolean('sla_breached')->default(false)->nullable();
            $table->string('source_ticket_id')->nullable();
            $table->boolean('is_direct_input')->default(false)->nullable();
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
