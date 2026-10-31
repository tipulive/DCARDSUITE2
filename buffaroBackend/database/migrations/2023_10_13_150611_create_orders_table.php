<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//Uid of dettes or orderId
            $table->string('uidUser')->default('none')->index('uidUser');//User linked to Orders
            $table->string('uidCreator')->default('none')->index('uidCreator');//who created
            $table->string('subscriber')->default('none')->index('subscriber');//who created
            $table->string('total')->default('0');//what he supposed to pay
            $table->string('paid')->default('0');//how much he paid
            $table->string('debt')->default('0')->index('debt');//debt
            $table->string('paidStatus')->default('none')->index('paidStatus');
            $table->string('Status')->default('none')->index('Status');
            $table->json('temporalData')->nullable();
            $table->string('systemUid')->default('none')->index("systemUid");
            $table->longtext('commentData')->nullable();//
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
        Schema::dropIfExists('orders');
    }
}
