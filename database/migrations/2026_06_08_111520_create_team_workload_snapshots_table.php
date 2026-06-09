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
        Schema::create('team_workload_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('team', 50);
            $table->integer('total_tickets')->default(0);
            $table->integer('open_tickets')->default(0);
            $table->integer('resolved_tickets')->default(0);
            $table->integer('overdue_tickets')->default(0);
            $table->decimal('average_response_time', 10, 2)->nullable();
            $table->decimal('average_resolution_time', 10, 2)->nullable();
            $table->decimal('sla_compliance', 5, 2)->nullable();
            $table->decimal('workload_percentage', 5, 2)->nullable();
            $table->date('snapshot_date')->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Index
            $table->index('team');
            $table->index('snapshot_date');
            $table->unique(['team', 'snapshot_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_workload_snapshots');
    }
};
