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
        Schema::create('tambons', function (Blueprint $table) {

                $table->id();
                $table->timestamps();

                $table->string('tambon')->nullable();
                $table->string('amphoe')->nullable();
                $table->string('province')->nullable();
                $table->string('zipcode')->nullable();
                $table->string('tambon_code')->nullable();
                $table->string('amphoe_code')->nullable();
                $table->string('province_code')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tambons');
    }
};
