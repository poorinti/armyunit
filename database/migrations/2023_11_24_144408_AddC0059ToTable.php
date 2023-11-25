<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0059ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('soldiers', function (Blueprint $table) {

            $table->string('soldier_disease_about')->nullable()->default('');
            $table->string('soldier_wantto_about')->nullable()->default('');

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
