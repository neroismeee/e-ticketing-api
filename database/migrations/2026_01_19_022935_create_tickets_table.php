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
            Schema::create('tickets', function (Blueprint $table) {
                $table->string('id')->primary();
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
                $table->timestamp('due_date')->nullable();
                $table->timestamp('resolved_date')->nullable();
                $table->timestamp('closed_date')->nullable();
                $table->boolean('sla_breached')->default(false);
                $table->decimal('response_time')->nullable();
                $table->decimal('resolution_time')->nullable();
                $table->decimal('estimated_effort')->nullable();
                $table->decimal('actual_effort')->nullable();
                $table->foreignId('parent_ticket_id')
                      ->nullable()
                      ->constrained('tickets')
                      ->nullOnDelete();
                $table->string('converted_to_type')->nullable();
                $table->string('converted_to_id')->nullable();
                $table->timestamp('converted_at')->nullable();
                $table->foreignId('converted_by')
                      ->nullable()
                      ->constrained('users')
                      ->onUpdate('cascade')
                      ->onDelete('cascade');
                $table->text('conversion_reason')->nullable();
                $table->timestamps();

            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
