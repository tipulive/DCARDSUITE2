<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidDettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_dettes', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//Uid
            $table->string('uidUser')->default('none')->index('uidUser');//User or client who
            $table->string('uidReceiver')->default('none')->index('uidReceiver');//nyiri deni
            $table->string('uidCreator')->default('none')->index('uidCreator');//who created ninawe wakiriye amafaranga yiryo deni
            $table->string('amount')->default('none');
            $table->string('paidStatus')->default('none')->index('paidStatus');
            $table->string('status')->default('none')->index('status');
            $table->json('temporalData')->nullable();
            $table->string('signature')->default('none')->index('signature');//finger print
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
        Schema::dropIfExists('paid_dettes');
    }
}
