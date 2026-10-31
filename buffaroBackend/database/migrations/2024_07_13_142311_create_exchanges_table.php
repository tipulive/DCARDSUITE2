<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {//this is currency according to dollars currency
            $table->id();
            $table->string('currency')->default('0')->index('currency');
            $table->string('currencyV')->default('0')->index('currencyV');
            $table->string('subscriber')->default('0')->index('subscriber');

            $table->timestamps();
        });
    }
    /*e.g: -usd:1
            -fc:2880
            -Rand:17
            -frw:1380 */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
