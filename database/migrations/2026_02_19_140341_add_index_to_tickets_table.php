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
        Schema::table('tickets', function (Blueprint $table) {
            $table->index('category');
            $table->index('priority');
            $table->index('status');
            $table->index('reporter_id');
            $table->index('assigned_to_id');
            $table->index('date_reported');
            $table->index('sla_breached');
            $table->index('converted_to_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['tickets_category_index']);
            $table->dropIndex(['tickets_priority_index']);
            $table->dropIndex(['tickets_status_index']);
            $table->dropIndex(['tickets_reporter_id_index']);
            $table->dropIndex(['tickets_assigned_to_id_index']);
            $table->dropIndex(['tickets_date_reported_index']);
            $table->dropIndex(['tickets_sla_breached_index']);
            $table->dropIndex(['tickets_converted_to_type_index']);
        });
    }
};
