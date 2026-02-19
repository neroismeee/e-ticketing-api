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
        Schema::table('feature_requests', function (Blueprint $table) {
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
        Schema::table('feature_requests', function (Blueprint $table) {
            $table->dropIndex(['feature_requests_request_type_index']);
            $table->dropIndex(['feature_requests_priority_index']);
            $table->dropIndex(['feature_requests_status_index']);
            $table->dropIndex(['feature_requests_reporter_id_index']);
            $table->dropIndex(['feature_requests_assigned_to_id_index']);
            $table->dropIndex(['feature_requests_sla_breached_index']);
            $table->dropIndex(['feature_requests_source_ticket_id_index']);
            $table->dropIndex(['feature_requests_is_direct_input_index']);
        });
    }
};
