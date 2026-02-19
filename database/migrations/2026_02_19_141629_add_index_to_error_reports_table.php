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
        Schema::table('error_reports', function (Blueprint $table) {
            $table->index('category');
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
        Schema::table('error_reports', function (Blueprint $table) {
            $table->dropIndex(['error_reports_category_index']);
            $table->dropIndex(['error_reports_priority_index']);
            $table->dropIndex(['error_reports_status_index']);
            $table->dropIndex(['error_reports_reporter_id_index']);
            $table->dropIndex(['error_reports_assigned_to_id_index']);
            $table->dropIndex(['error_reports_sla_breached_index']);
            $table->dropIndex(['error_reports_source_ticket_id_index']);
            $table->dropIndex(['error_reports_is_direct_input_index']);
        });
    }
};
