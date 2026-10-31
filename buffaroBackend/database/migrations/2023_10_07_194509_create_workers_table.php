<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) { //this is workers contract dettes
            $table->id();
            $table->string('uidUser')->default('none')->index('uidUser');//Worker uid
            $table->string('uidCreator')->default('none')->index('uidCreator');//Who created Workers
            $table->string('amount')->default('none'); //salary paid
            $table->string('position')->default('none')->index("position"); //salary paid
            $table->string('systemUid')->default('none')->index("systemUid"); //salary paid
            $table->string('jobContract')->default('none')->index("jobContract"); //permanent or contract
            $table->json('temporalData')->nullable();
            $table->string('started_at')->default('none')->index("started_at");//dated he started Jobs
            $table->string('datePaid_at')->default('none')->index("datePaid_at");//for beginning datePaid_at=started_at
            $table->string('paid_at')->default('none')->index("paid_at");//30 days, 1week,1 hours and so on
            $table->string('status')->default('none')->index('status'); //suspended or at work
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
        Schema::dropIfExists('workers');
    }
}
