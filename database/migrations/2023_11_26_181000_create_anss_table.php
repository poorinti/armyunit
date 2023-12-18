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
        Schema::create('anss', function (Blueprint $table) {

            $table->string('ans_id',50)->primary();
            $table->string('ans_name',200)->nullable()->default('')->index();
            $table->string('ans_image',200)->nullable()->default('')->index();
            $table->string('ans_index_name',200)->nullable()->default('')->index();
            $table->integer('ans_index')->nullable()->default(0);
            $table->string('ans_dep_id',50)->nullable()->default('')->index();
            $table->string('ans_dep_name',200)->nullable()->default('')->index();
            $table->string('ans_bat_id',50)->nullable()->default('')->index();
            $table->string('ans_bat_name',200)->nullable()->default('')->index();
            $table->integer('ans_year')->nullable()->default(0);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anss');
    }
};
