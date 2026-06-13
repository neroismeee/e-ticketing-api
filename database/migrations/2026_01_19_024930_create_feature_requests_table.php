<?php

use App\Enums\FeatureRequestStatus;
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
        Schema::create('feature_requests', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title', 200);
            $table->text('description');
            $table->string('request_type', 50);
            $table->string('priority', 50);
            $table->string('status', 50)->default(FeatureRequestStatus::PendingApproval->value);
            $table->integer('progress')->default(0);
            $table->foreignId('reporter_id')
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('assigned_to_id')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('assigned_team', 50)->nullable();
            $table->timestamp('date_submitted')->useCurrent();
            $table->timestamp('approval_date')->nullable();
            $table->timestamp('assignment_date')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->timestamp('review_date')->nullable();
            $table->decimal('estimated_effort', 10, 2)->nullable();
            $table->decimal('actual_effort', 10, 2)->nullable();
            $table->decimal('sla_time_elapsed', 10, 2)->nullable();
            $table->decimal('sla_time_remaining', 10, 2)->nullable();
            $table->boolean('sla_breached')->default(false);
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->text('rejection_reason')->nullable();
            $table->text('roi_impact')->nullable();
            $table->text('quality_impact')->nullable();
            $table->text('post_implementation_notes')->nullable();
            $table->string('source_ticket_id')->nullable();
            $table->foreign('source_ticket_id')
                  ->references('id')
                  ->on('tickets')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->boolean('is_direct_input')->default(false);
            $table->timestamps();

            // Index
            $table->index('request_type');
            $table->index('priority');
            $table->index('status');
            $table->index('reporter_id');
            $table->index('assigned_to_id');
            $table->index('sla_breached');
            $table->index('source_ticket_id');
            $table->index('is_direct_input');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_requests');
    }
};
