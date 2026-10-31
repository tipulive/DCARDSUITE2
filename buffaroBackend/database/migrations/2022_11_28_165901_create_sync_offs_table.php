<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sync_offs', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index("uid");
            $table->string('versionCount')->index("versionCount");
            $table->string('subscriber')->index("subscriber");
            $table->string('actionName')->index("actionName");
            $table->string('tableName')->index("tableName");
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
        Schema::dropIfExists('sync_offs');
    }
}
