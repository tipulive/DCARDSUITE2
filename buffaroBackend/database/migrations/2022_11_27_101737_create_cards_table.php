<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index("uid");
            $table->string('CardNumber')->index("CardNumber");
            $table->string('uidCreator')->index("uidCreator");
            $table->string('filename')->default("none");
            $table->string('status')->index("status")->default("not printed");

            $table->string('subscriber')->index("subscriber");
            $table->string('uidUploader')->index("uidUploader")->default("none");
            $table->string('SyncAdd')->default("none");
            $table->string('SyncUpdate')->default("none");

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
        Schema::dropIfExists('cards');
    }
}
