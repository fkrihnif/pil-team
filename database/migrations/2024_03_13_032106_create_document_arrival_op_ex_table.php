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
        Schema::create('document_arrival_op_ex', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operation_export_id')->nullable()->constrained("operation_export")->cascadeOnUpdate()->nullOnDelete();
            $table->text('document')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_arrival_op_ex');
    }
};
