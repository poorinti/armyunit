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
        Schema::create('ranks', function (Blueprint $table) {

            $table->string('rank_id',50)->primary();
            $table->string('rank_name',200)->nullable()->default('')->index();
            $table->integer('nco_rank_index')->nullable()->default(0)->index();
            $table->integer('cco_rank_index')->nullable()->default(0)->index();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranks');
    }
};
