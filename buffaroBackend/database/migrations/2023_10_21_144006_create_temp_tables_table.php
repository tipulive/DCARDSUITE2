<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_tables', function (Blueprint $table) {
            $table->id();
            $table->String('uid')->index('uid');
            $table->String('name')->index('name');
            $table->String('uidCreator')->index('uidCreator');
            $table->json('tempData')->nullable();
            $table->string('status')->default('none')->index("status");
            $table->string('subscriber')->default('none')->index("subscriber");
            $table->string('actionTable')->default('none')->index("actionTable");
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
        Schema::dropIfExists('temp_tables');
    }
}
