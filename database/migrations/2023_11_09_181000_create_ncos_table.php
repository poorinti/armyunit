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
        Schema::create('ncos', function (Blueprint $table) {

            $table->string('nco_id',50)->primary();
            $table->string('nco_rank',200)->nullable()->default('')->index();
            $table->integer('nco_rank_index')->nullable()->default(0);
            $table->string('nco_name',200)->nullable()->default('')->index();
            $table->string('nco_rtanumber',50)->nullable()->default('')->index();
            $table->string('nco_image',200)->nullable();
            $table->string('nco_address',200)->nullable()->default('')->index();
            $table->string('nco_province')->nullable()->default('');
            $table->string('nco_amphoe')->nullable()->default('');
            $table->string('nco_zip',200)->nullable()->default('')->index();
            $table->string('nco_intern',200)->nullable()->default('')->index();
            $table->string('nco_corp',200)->nullable()->default('')->index();
            $table->date('nco_startdate')->nullable();
            $table->string('nco_phone',200)->nullable()->default('')->index();
            $table->string('nco_about',200)->nullable()->default('')->index();

            $table->integer('nco_law_index')->nullable()->default(0);
            $table->string('nco_law_id',50)->nullable()->default('')->index();
            $table->integer('nco_law_rank_index')->nullable()->default(0);
            $table->string('nco_law_rank',200)->nullable()->default('')->index();
            $table->string('nco_law_name',200)->nullable()->default('')->index();
            $table->string('nco_law_defective',200)->nullable()->default('')->index();
            $table->string('nco_law_defective_about',200)->nullable()->default('')->index();
            $table->string('nco_law_m3_join',200)->nullable()->default('')->index();
            $table->string('nco_law_m7_join',200)->nullable()->default('')->index();
            $table->string('nco_law_reward',200)->nullable()->default('')->index();
            $table->string('nco_law_parent',200)->nullable()->default('')->index();

            $table->integer('dep_index')->nullable()->default(0);
            $table->string('nco_dep_id',50)->nullable()->default('')->index();
            $table->string('nco_dep_name',200)->nullable()->default('')->index();
            $table->string('nco_bat_id',50)->nullable()->default('')->index();
            $table->string('nco_bat_name',200)->nullable()->default('')->index();
            $table->integer('nco_year')->nullable()->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ncos');
    }
};
