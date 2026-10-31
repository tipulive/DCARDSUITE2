<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participateds', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//events uid
            $table->string('uidUser')->index('uidUser');//User or client who participateds in Events
            $table->string('uidCreator')->default('none')->index('uidCreator');
            $table->string('carduid')->default('none')->index('carduid');
            $table->string('subscriber')->default('none')->index('subscriber');

            $table->string('promotion_msg')->default('none');//company Name
            $table->string('inputData')->default('0')->index('inputData');

            $table->string('token')->default('none')->index('token');
            $table->string('started_date')->default('none')->index("started_date");
            $table->string('ended_date')->default('none')->index("ended_date");
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
        Schema::dropIfExists('participateds');
    }
}
