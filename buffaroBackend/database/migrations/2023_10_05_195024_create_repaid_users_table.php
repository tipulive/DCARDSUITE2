<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepaidUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repaid_users', function (Blueprint $table) {//where user give u money ,but you are not owner,
            //you need to pay to another Owner :ex:client want to pay Alex,but once he paid me,i need to pay me too Alex
            $table->id();
            $table->string('uid')->index('uid');//Uid
            $table->string('uidPaid')->default('none')->index('uidPaid');//User Who will paid
            $table->string('uidReceiver')->default('none')->index('uidReceiver');//uyakiriye
            $table->string('amount')->default('none');
            $table->string('status')->default('none')->index('status');
            $table->string('subscriber')->default('none')->index('subscriber');
            $table->string('systemUid')->default('none')->index("systemUid");//systemUid
            $table->string('signature')->default('none')->index('signature');//finger print
            $table->string('purpose')->default('none')->index("purpose");
            $table->json('temporalData')->nullable();
            $table->longtext('commentData')->nullable();//
            $table->longtext('receiverComment')->nullable();//
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
        Schema::dropIfExists('repaid_users');
    }
}
