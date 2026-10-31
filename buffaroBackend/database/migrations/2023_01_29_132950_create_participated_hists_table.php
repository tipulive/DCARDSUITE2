<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipatedHistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participated_hists', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//events uid
            $table->string('uidUser')->default('none')->index('uidUser');//User or client who participateds in Events
            $table->string('uidCreator')->default('none')->index('uidCreator');
            $table->string('carduid')->default('none')->index('carduid');
            $table->string('subscriber')->default('none')->index('subscriber');

            $table->string('promotion_msg')->default('none');//company Name
            $table->string('inputData')->default('0');
            $table->string('actionName')->default('none')->index('actionName');


            $table->string('token')->default('none');
            $table->string('started_date')->default('none');
            $table->string('ended_date')->default('none');
            $table->string('status')->default('none');
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
        Schema::dropIfExists('participated_hists');
    }
}
