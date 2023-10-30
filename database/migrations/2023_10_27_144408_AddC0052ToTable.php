<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0052ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soldiers', function (Blueprint $table) {

            $table->string('soldiers_teacher',200)->nullable()->default('')->index();
            $table->string('soldiers_now',200)->nullable()->default('')->index();
            $table->string('soldiers_term',200)->nullable()->default('')->index();
            $table->string('soldier_course',200)->nullable()->default('')->index();

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
