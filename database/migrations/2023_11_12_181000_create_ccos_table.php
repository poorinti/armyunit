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
        Schema::create('ccos', function (Blueprint $table) {

            $table->string('cco_id',50)->primary();
            $table->string('cco_rank',200)->nullable()->default('')->index();
            $table->integer('cco_rank_index')->nullable()->default(0)->index();
            $table->string('cco_name',200)->nullable()->default('')->index();
            $table->string('cco_rtanumber',50)->nullable()->default('')->index();
            $table->string('cco_image',200)->nullable();
            $table->string('cco_address',200)->nullable()->default('')->index();
            $table->string('cco_province')->nullable()->default('');
            $table->string('cco_amphoe')->nullable()->default('');
            $table->string('cco_zip',200)->nullable()->default('')->index();
            $table->string('cco_intern',200)->nullable()->default('')->index();
            $table->string('cco_corp',200)->nullable()->default('')->index();
            $table->date('cco_startdate')->nullable();
            $table->string('cco_phone',200)->nullable()->default('')->index();
            $table->string('cco_about',200)->nullable()->default('')->index();

            $table->string('cco_sick_have',200)->nullable()->default('')->index();
            $table->string('cco_sick',200)->nullable()->default('')->index();


            $table->integer('cco_law_index')->nullable()->default(0)->index();
            $table->string('cco_law_id',50)->nullable()->default('')->index();
            $table->integer('cco_law_rank_index')->nullable()->default(0);
            $table->string('cco_law_rank',200)->nullable()->default('')->index();
            $table->string('cco_law_name',200)->nullable()->default('')->index();
            $table->string('cco_law_defective',200)->nullable()->default('')->index();
            $table->string('cco_law_defective_about',200)->nullable()->default('')->index();
            $table->string('cco_law_m3_join',200)->nullable()->default('')->index();
            $table->string('cco_law_m7_join',200)->nullable()->default('')->index();
            $table->string('cco_law_reward',200)->nullable()->default('')->index();
            $table->string('cco_law_parent',200)->nullable()->default('')->index();

            $table->integer('dep_index')->nullable()->default(0)->index();
            $table->string('cco_dep_id',50)->nullable()->default('')->index();
            $table->string('cco_dep_name',200)->nullable()->default('')->index();
            $table->string('cco_bat_id',50)->nullable()->default('')->index();
            $table->string('cco_bat_name',200)->nullable()->default('')->index();
            $table->integer('cco_year')->nullable()->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ccos');
    }
};
