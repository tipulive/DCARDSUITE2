<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafProductlosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saf_productloses', function (Blueprint $table) {
            $table->id();

            $table->string('SafariId')->default('none')->index();
            $table->string('productCode')->index();
            $table->string('subscriber', 21)->default('none')->index();
            $table->string('order_creator')->default('none')->index();

            $table->string('price')->default("0"); // More appropriate for monetary values
            $table->string('qty')->index();
            $table->string('qty_count')->default("0");
            $table->string('total');
            $table->longtext('commentData')->nullable();

            $table->string('status')->default('Open')->index();
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
        Schema::dropIfExists('saf_productloses');
    }
}
