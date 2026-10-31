<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dettes', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//dettes Uid
            $table->string('uidUser')->default('none')->index('uidUser');//User or client who participateds in Events
            $table->string('uidCreator')->default('none')->index('uidCreator');
            $table->string('amount')->default('none');
            $table->string('paidAmount')->default('none');
            $table->string('status')->default('none')->index('status');
            $table->json('temporalData')->nullable();
            $table->string('systemUid')->default('none')->index("systemUid");
            $table->string('subscriber')->default('none')->index('subscriber');//Company
            $table->string('purpose')->default('none')->index("purpose");//Cyungu and so on
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
        Schema::dropIfExists('dettes');
    }
}
