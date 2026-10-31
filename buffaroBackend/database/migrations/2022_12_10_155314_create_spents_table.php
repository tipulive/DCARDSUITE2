<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spents', function (Blueprint $table) {
            $table->id();
            $table->string('safariuid')->default('none')->index('safariuid');
            $table->string('price')->default('none');
            $table->longtext('comment')->nullable();
            $table->string('uidCreator')->default('none')->index('uidCreator');
            $table->string('subscriber')->default('none')->index("subscriber");
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
        Schema::dropIfExists('spents');
    }
}
