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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('size');
            $table->string('type');
            $table->string('url');
            $table->string('attachmentable_id');
            $table->string('attachmentable_type');
            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->onUpdate('cascade')
                ->nullOnDelete();
            $table->timestamp('uploaded_at')->useCurrent();

            $table->index(['attachmentable_id', 'attachmentable_type']);
            $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
