<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempusers', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid')->unique();
            $table->string('meterNo')->default('0')->index('meterNo');
            $table->string('sessionKey')->default('0')->index('sessionKey');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempusers');
    }
}
