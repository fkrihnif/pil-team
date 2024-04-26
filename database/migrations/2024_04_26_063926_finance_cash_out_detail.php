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
        Schema::create('finance_cash_out_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('head_id')->nullable()->constrained("finance_cash_out_head")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('account_id')->nullable()->constrained("master_account")->cascadeOnUpdate()->nullOnDelete();
            $table->string('seq')->nullable();
            $table->string('description')->nullable();
            $table->string('total')->nullable();
            $table->string('remark')->nullable();
            $table->foreignId('created_by')->nullable()->constrained("users")->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained("users")->cascadeOnUpdate()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_cash_out_detail');
    }
};
