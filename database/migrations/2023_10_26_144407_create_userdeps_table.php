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
        Schema::create('userdeps', function (Blueprint $table) {
            //$table->engine = 'MyISAM';
            $table->string('user_id',50)->default('');
            $table->string('dep_id',50)->default('');
            $table->primary(['user_id', 'dep_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('userdeps');
    }
};
