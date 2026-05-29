<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiniAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mini_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('uidOwner')->index("uidOwner");
            $table->string('ownerSubscriber')->index("ownerSubscriber");

            $table->string('miniOwner')->index("miniOwner");
            $table->string('miniOwnerSubscriber')->index("miniOwnerSubscriber");

            $table->string('uidCreator');

            $table->string('addedStatus')->default('0');
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
        Schema::dropIfExists('mini_accounts');
    }
}
