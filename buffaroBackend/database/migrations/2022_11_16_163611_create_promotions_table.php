<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//Promotion or event Uid
            $table->string('uidCreator')->index('uidCreator');//User or client who participateds in Events
            $table->string('subscriber')->default('none')->index("subscriber");//company Name
            $table->string('token')->default('none')->index('token');

            $table->string('promoName')->default('none')->index('promoName');
            $table->string('promo_msg')->default('none')->index('promo_msg');
            $table->string('reach')->default('none')->index('reach');
            $table->string('gain')->default('none')->index('gain');
            $table->string('type_service')->default('none');
            $table->string('started_date')->default('none')->index("started_date");//current timestamp
            $table->string('ended_date')->default('none')->index("ended_date");//current timestamp
            $table->string('status')->default('none')->index("status");
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
        Schema::dropIfExists('promotions');
    }
}
