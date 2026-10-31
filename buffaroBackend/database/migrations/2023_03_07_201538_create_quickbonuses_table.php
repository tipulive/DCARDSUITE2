<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickbonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quickbonuses', function (Blueprint $table) {
            $table->id();

            $table->string('quickUid')->default('none')->index('quickUid');//this will make us trace quickBonuse
            $table->string('productName')->default('none')->index('productName');
            $table->string('qty')->default('none');
            $table->string('price')->default('none');
            $table->string('status')->default('on')->index("status");
            $table->string('bonusType')->default('none')->index("bonusType");//Gift or Money
            $table->string('giftName')->default('none')->index("giftName");// name of code of that carton
            $table->string('giftValues')->default('none');//price per carton
            $table->string('giftPerPcs')->default('1');//price per pcs
            $table->string('giftMin')->default('1');//Min gift you can give to client
            $table->string('moneyMin')->default('1');//Money Minimum
            $table->string('bonusValue')->default('none');//Bonus Value per 1 pcs means if is gift BonusValue=giftPerPcs

            $table->string('uidCreator')->default('none')->index('uidCreator');//Creator
            $table->string('subscriber')->default('none')->index('subscriber');//Company

            $table->longtext('description')->nullable();//Company

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
        Schema::dropIfExists('quickbonuses');
    }
}
