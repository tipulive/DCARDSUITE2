<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topup_histories', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//userid
            $table->string('uidCreator')->default('none');//User or client who participateds in Events
            $table->string('amount')->default('none');
            $table->string('action')->default('none');
            $table->string('balance')->default('0')->index("balance");
            $table->string('balance_status')->default('balance')->index("balance_status");// on edit to revoke status of balance
            $table->string('bonus')->default('0')->index("bonus");
            $table->string('bonus_status')->default('bonus')->index("bonus_status");//on edit to revoke status of bonus
            $table->string('CBalance')->default('US');//currency Balance
            $table->string('CBonus')->default('US');

            $table->string('subscriber')->default('none')->index('subscriber');//Company
            $table->string('purpose')->default('none');//Company
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
        Schema::dropIfExists('topup_histories');
    }
}
