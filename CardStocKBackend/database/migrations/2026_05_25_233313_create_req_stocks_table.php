<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReqStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('req_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');// Uid
            $table->string('productCode')->index('productCode');//
            $table->string('qty')->dafault('0');//
            $table->string('uidSender')->index('uidSender');//

            $table->string('status')->index('status');//
            $table->string('subscriber')->default('none')->index("subscriber");//company Name
            $table->string('uidReceiver')->default('none')->index("uidReceiver");//company Name
            $table->string('recSubscriber')->default('none')->index("recSubscriber");//company Name
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
        Schema::dropIfExists('req_stocks');
    }
}
