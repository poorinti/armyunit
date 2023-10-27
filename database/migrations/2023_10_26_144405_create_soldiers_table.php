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
        Schema::create('soldiers', function (Blueprint $table) {

            $table->string('soldier_id',50)->primary();
            $table->string('soldier_name',200);
            $table->string('soldier_image',200)->nullable();
            $table->string('soldier_address',200)->nullable()->default('')->index();
            $table->string('soldier_country',200)->nullable()->default('')->index();
            $table->string('soldier_state',200)->nullable()->default('')->index();
            $table->string('soldier_zip',200)->nullable()->default('')->index();
            $table->string('soldier_intern',200)->nullable()->default('')->index();
            $table->string('soldier_corp',200)->nullable()->default('')->index();
            $table->string('soldier_education',200)->nullable()->default('')->index();
            $table->string('soldier_skill',200)->nullable()->default('')->index();
            $table->date('soldier_startdate')->nullable();
            $table->date('soldier_enddate')->nullable();
            $table->string('soldier_phone',200)->nullable()->default('')->index();
            $table->string('soldier_about',200)->nullable()->default('')->index();
            $table->string('soldier_dep_id',50)->nullable()->default('')->index();
            $table->string('soldiers_dep_name',200)->nullable()->default('')->index();
            $table->string('soldiers_bat_id',50)->nullable()->default('')->index();
            $table->string('soldiers_bat_name',200)->nullable()->default('')->index();
            $table->string('soldier_rtanumber',50)->nullable()->default('')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soldiers');
    }
};
