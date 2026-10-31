<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_buys', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid')->unique();
            $table->string('meterNo')->default('0')->index('meterNo');
            $table->string('token')->default('0')->index('token');
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
        Schema::dropIfExists('history_buys');
    }
}
