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
            $table->dropIndex(['category']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['status']);
            $table->dropIndex(['reporter_id']);
            $table->dropIndex(['assigned_to_id']);
            $table->dropIndex(['sla_breached']);
            $table->dropIndex(['source_ticket_id']);
            $table->dropIndex(['is_direct_input']);
        });
    }
};
