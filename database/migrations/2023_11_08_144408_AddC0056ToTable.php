<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0056ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soldiers', function (Blueprint $table) {

            $table->string('soldier_education_study',200)->nullable()->default('')->index();
            $table->string('soldier_education_end',200)->nullable()->default('')->index();
            $table->string('soldier_wantto',200)->nullable()->default('')->index();
            $table->string('soldier_health',200)->nullable()->default('')->index();
            $table->string('soldier_want_nco',200)->nullable()->default('')->index();
            $table->string('soldier_want_skill',200)->nullable()->default('')->index();
            $table->string('soldier_disease',200)->nullable()->default('')->index();
            $table->string('soldier_relative_name1',200)->nullable()->default('')->index();
            $table->string('soldier_relative_phone1',200)->nullable()->default('')->index();
            $table->string('soldier_relative_add1',200)->nullable()->default('')->index();
            $table->string('soldier_relative_name2',200)->nullable()->default('')->index();
            $table->string('soldier_relative_phone2',200)->nullable()->default('')->index();
            $table->string('soldier_relative_add2',200)->nullable()->default('')->index();


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('soldiers', function (Blueprint $table) {
            
        });
    }
}
