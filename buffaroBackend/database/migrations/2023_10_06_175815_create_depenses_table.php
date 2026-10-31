<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) { //SystemUid izaba ari GeneralSpend
            $table->id();
            $table->string('uid')->index('uid');//Uid
            $table->string('uidUser')->default('none')->index('uidUser');//User Who did depense
            $table->string('uidCreator')->default('none')->index('uidCreator');//uyakiriye
            $table->string('amount')->default('none');
            $table->string('status')->default('none')->index('status');
            $table->string('subscriber')->default('none')->index('subscriber');
            $table->json('temporalData')->nullable();
            $table->string('systemUid')->default('none')->index("systemUid");//systemUid
            $table->string('purpose')->default('none')->index("purpose");
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
        Schema::dropIfExists('depenses');
    }
}
