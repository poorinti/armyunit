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
        Schema::create('pays', function (Blueprint $table) {

            $table->string('pay_id',50)->primary();
            $table->string('pay_rank',200)->nullable()->default('')->index();
            $table->string('pay_name',200)->nullable()->default('')->index();
            $table->integer('pay_rank_index')->nullable()->default(0);
            $table->string('pay_rank_index_name',50)->nullable()->default('')->index();
            $table->string('pay_image',200)->nullable();

            $table->integer('pay_index')->nullable()->default(0)->index();

            $table->string('pay_rtanumber',50)->nullable()->default('')->index();
            $table->string('pay_province')->nullable()->default('');
            $table->string('pay_amphoe')->nullable()->default('');
            $table->string('pay_intern',200)->nullable()->default('')->index();
            $table->string('pay_corp',200)->nullable()->default('')->index();
            $table->date('pay_startdate')->nullable();
            $table->string('pay_phone',200)->nullable()->default('')->index();
            $table->string('pay_about',200)->nullable()->default('')->index();
            $table->string('pay_address',200)->nullable()->default('')->index();
            $table->string('pay_zip',200)->nullable()->default('')->index();
            $table->string('pay_defective',200)->nullable()->default('')->index();
            $table->string('pay_defective_about',200)->nullable()->default('')->index();
            $table->string('pay_m3_join',200)->nullable()->default('')->index();
            $table->string('pay_m7_join',200)->nullable()->default('')->index();
            $table->string('pay_reward',200)->nullable()->default('')->index();
            $table->string('pay_parent_about',200)->nullable()->default('')->index();
            //ดิบ
            $table->string('pay_parent_id',50)->nullable()->default('')->index();
            $table->string('pay_parent_rank',200)->nullable()->default('')->index();
            $table->string('pay_parent_rank_index',200)->nullable()->default('')->index();
            $table->string('pay_parent_name',200)->nullable()->default('')->index();
            $table->string('pay_parent_phone',200)->nullable()->default('')->index();
            $table->string('pay_nco_index',50)->nullable()->default('')->index();
            $table->string('pay_cco_index',50)->nullable()->default('')->index();
            //
            $table->string('pay_payout_index',50)->nullable()->default('')->index();
            $table->string('pay_payout',200)->nullable()->default('')->index();

            $table->integer('dep_index')->nullable()->default(0)->index();
            $table->string('pay_dep_id',50)->nullable()->default('')->index();
            $table->string('pay_dep_name',200)->nullable()->default('')->index();
            $table->string('pay_bat_id',50)->nullable()->default('')->index();
            $table->string('pay_bat_name',200)->nullable()->default('')->index();
            $table->integer('pay_year')->nullable()->default(0);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pays');
    }
};
