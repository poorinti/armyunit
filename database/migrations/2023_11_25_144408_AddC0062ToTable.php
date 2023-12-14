<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0062ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ncos', function (Blueprint $table) {


            $table->string('nco_job',200)->nullable()->default('')->index();
            $table->string('nco_wantto_about',200)->nullable()->default('')->index();
            $table->string('nco_health_about',200)->nullable()->default('')->index();

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
