<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafariProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safari_products', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->default('none')->index('uid');
            $table->string('safariuid')->default('none')->index('safariuid');
            $table->string('price')->default('none');
            $table->string('SoldInterest')->default('5');
            $table->string('currency')->default('none');
            $table->string('exchangeRate')->default('none');
            $table->string('typeData')->default('product')->index("typeData");
            $table->string('status')->default('none')->index("status");
            $table->string('qty')->default('none');
            $table->string('pcs')->default('none');
            $table->string('size')->default('none');
            $table->longtext('comment')->nullable();
            $table->string('uidCreator')->default('none')->index('uidCreator');
            $table->string('subscriber')->default('none')->index("subscriber");
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
        Schema::dropIfExists('safari_products');
    }
}
