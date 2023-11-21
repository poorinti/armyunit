<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0058ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ncos', function (Blueprint $table) {


            $table->string('nco_education',200)->nullable()->default('')->index();
            $table->string('nco_education_study',200)->nullable()->default('')->index();
            $table->string('nco_education_end',200)->nullable()->default('')->index();
            $table->string('nco_wantto',200)->nullable()->default('')->index();
            $table->string('nco_health',200)->nullable()->default('')->index();
            $table->string('nco_skill_work',200)->nullable()->default('')->index();
            $table->string('nco_skill',200)->nullable()->default('')->index();
            $table->string('nco_wife_name',200)->nullable()->default('')->index();
            $table->string('nco_child_name1',200)->nullable()->default('')->index();
            $table->string('nco_child_name2',200)->nullable()->default('')->index();
            $table->string('nco_child_name3',200)->nullable()->default('')->index();
            $table->string('nco_child_name4',200)->nullable()->default('')->index();
            $table->string('nco_child_name5',200)->nullable()->default('')->index();


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ncos', function (Blueprint $table) {

        });
    }
}
