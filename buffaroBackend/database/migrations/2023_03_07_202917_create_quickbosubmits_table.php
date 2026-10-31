<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickbosubmitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quickbosubmits', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->default('none')->index('uid');//id generated when submitted data
            $table->string('quickUid')->default('none')->index('quickUid');//this will make us trace quickBonuse
            $table->string('uidUser')->default('none')->index('uidUser');
            $table->string('productName')->default('none')->index('productName');
            $table->string('qty')->default('none');
            $table->string('price')->default('none');
            $table->string('total')->default('none');
            $table->string('status')->default('on')->index("status");
            $table->string('bonusType')->default('none')->index("bonusType");//Gift or Money
            $table->string('giftName')->default('none')->index("giftName");// name of code of that carton
            $table->string('giftPcs')->default('none');
            $table->string('bonusValue')->default('none');//Bonus Value per 1 pcs means if is gift BonusValue=giftPerPcs
            $table->string('totBonusValue')->default('none');//Total bonus value i.e:bonusValue*giftPcs
            $table->string('uidCreator')->default('none')->index('uidCreator');//User or client who participateds in Events
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
        Schema::dropIfExists('quickbosubmits');
    }
}
