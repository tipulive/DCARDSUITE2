<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid')->unique();//userid
            $table->string('uidCreator')->default('none')->index('uidCreator');//User or client who participateds in Events
            $table->string('balance')->default('0')->index("balance");
            $table->string('bonus')->default('0')->index("bonus");
            $table->string('CBalance')->default('US')->index("CBalance");//currency Balance
            $table->string('CBonus')->default('US')->index("CBonus");//currency Balance
            $table->string('subscriber')->default('none')->index('subscriber');//Company
            $table->string('purpose')->default('none')->index('purpose');//Company
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
        Schema::dropIfExists('topups');
    }
}
