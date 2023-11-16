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
        Schema::create('laws', function (Blueprint $table) {

            $table->string('law_id',50)->primary();
            $table->string('law_rank',200)->nullable()->default('')->index();
            $table->string('law_name',200)->nullable()->default('')->index();
            $table->integer('law_rank_index')->nullable()->default(0);
            $table->string('law_rank_index_name',50)->nullable()->default('')->index();
            $table->string('law_image',200)->nullable();

            $table->integer('law_index')->nullable()->default(0)->index();

            $table->string('law_rtanumber',50)->nullable()->default('')->index();
            $table->string('law_province')->nullable()->default('');
            $table->string('law_amphoe')->nullable()->default('');
            $table->string('law_intern',200)->nullable()->default('')->index();
            $table->string('law_corp',200)->nullable()->default('')->index();
            $table->date('law_startdate')->nullable();
            $table->string('law_phone',200)->nullable()->default('')->index();
            $table->string('law_about',200)->nullable()->default('')->index();
            $table->string('law_address',200)->nullable()->default('')->index();
            $table->string('law_zip',200)->nullable()->default('')->index();
            $table->string('law_defective',200)->nullable()->default('')->index();
            $table->string('law_defective_about',200)->nullable()->default('')->index();
            $table->string('law_m3_join',200)->nullable()->default('')->index();
            $table->string('law_m7_join',200)->nullable()->default('')->index();
            $table->string('law_reward',200)->nullable()->default('')->index();
            $table->string('law_parent_about',200)->nullable()->default('')->index();
            //ดิบ
            $table->string('law_parent_id',50)->nullable()->default('')->index();
            $table->string('law_parent_rank',200)->nullable()->default('')->index();
            $table->string('law_parent_rank_index',200)->nullable()->default('')->index();
            $table->string('law_parent_name',200)->nullable()->default('')->index();
            $table->string('law_parent_phone',200)->nullable()->default('')->index();
            $table->string('law_nco_index',50)->nullable()->default('')->index();
            $table->string('law_cco_index',50)->nullable()->default('')->index();

            $table->integer('dep_index')->nullable()->default(0)->index();
            $table->string('law_dep_id',50)->nullable()->default('')->index();
            $table->string('law_dep_name',200)->nullable()->default('')->index();
            $table->string('law_bat_id',50)->nullable()->default('')->index();
            $table->string('law_bat_name',200)->nullable()->default('')->index();
            $table->integer('law_year')->nullable()->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laws');
    }
};
