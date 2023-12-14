<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0063ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {

            $table->string('cco_image',200)->nullable();
            $table->string('nco_image',200)->nullable();
            $table->string('soldier_image',200)->nullable();
            $table->string('law_image',200)->nullable();
            $table->string('pay_image',200)->nullable();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {

        });
    }
}
