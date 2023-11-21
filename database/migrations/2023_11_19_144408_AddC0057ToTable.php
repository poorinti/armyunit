<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0057ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ccos', function (Blueprint $table) {


            $table->string('cco_education',200)->nullable()->default('')->index();
            $table->string('cco_education_study',200)->nullable()->default('')->index();
            $table->string('cco_education_end',200)->nullable()->default('')->index();
            $table->string('cco_wantto',200)->nullable()->default('')->index();
            $table->string('cco_health',200)->nullable()->default('')->index();
            $table->string('cco_skill_work',200)->nullable()->default('')->index();
            $table->string('cco_skill',200)->nullable()->default('')->index();
            $table->string('cco_wife_name',200)->nullable()->default('')->index();
            $table->string('cco_child_name1',200)->nullable()->default('')->index();
            $table->string('cco_child_name2',200)->nullable()->default('')->index();
            $table->string('cco_child_name3',200)->nullable()->default('')->index();
            $table->string('cco_child_name4',200)->nullable()->default('')->index();
            $table->string('cco_child_name5',200)->nullable()->default('')->index();


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ccos', function (Blueprint $table) {

        });
    }
}
