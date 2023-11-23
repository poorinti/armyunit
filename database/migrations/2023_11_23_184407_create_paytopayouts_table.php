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
        Schema::create('paytopayouts', function (Blueprint $table) {
            //$table->engine = 'MyISAM';
            $table->string('pay_id',50)->default('');
            $table->string('payout_id',50)->default('');
            $table->string('payout_date',200)->default('');
            $table->primary(['pay_id', 'payout_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paytopayouts');
    }
};
