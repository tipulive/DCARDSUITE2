<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaidAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repaid_admins', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index('uid');//
            $table->string('uidPaid')->index('uidPaid');//
            $table->string('amount')->default('none');
            $table->string('subscriber')->default('none')->index("subscriber");//company Name
            $table->string('uidReceiver')->default('none')->index("uidReceiver");//company Name
            $table->string('purpose')->default('none');//Cyungu and so on
            $table->string('systemUid')->default('none')->index("systemUid");
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
        Schema::dropIfExists('repaid_admins');
    }
}
