<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddC0061ToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ccos', function (Blueprint $table) {


            $table->string('cco_job',200)->nullable()->default('')->index();
            $table->string('cco_wantto_about',200)->nullable()->default('')->index();
            $table->string('cco_health_about',200)->nullable()->default('')->index();



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
