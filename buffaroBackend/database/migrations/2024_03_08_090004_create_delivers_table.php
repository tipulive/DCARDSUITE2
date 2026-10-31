<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivers', function (Blueprint $table) {
            $table->id();
            $table->String('uid')->index('uid');
            $table->String('productCode')->index('productCode');
            $table->String('uidTransport')->index('uidTransport')->default('none');
            $table->String('qty_Transport')->default('none');
            $table->String('StockName')->default('none');
            $table->String('stockDeliver')->index('stockDeliver');
            $table->String('subscriber')->index('subscriber');
            $table->longtext('commentData')->nullable();
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
        Schema::dropIfExists('delivers');
    }
}
