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
            $table->dropIndex(['category']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['status']);
            $table->dropIndex(['reporter_id']);
            $table->dropIndex(['assigned_to_id']);
            $table->dropIndex(['date_reported']);
            $table->dropIndex(['sla_breached']);
            $table->dropIndex(['converted_to_type']);
        });
    }
};
