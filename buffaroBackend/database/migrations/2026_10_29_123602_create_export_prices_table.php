<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up(): void
    {
        Schema::create('exportProductPrice', function (Blueprint $table) {
            $table->id();
            $table->string('productCode', 191)->index();
            $table->string('qty', 191); // VARCHAR(191) as requested
            $table->string('currency', 191)->index()->default('none');
            $table->string('status', 191)->index()->default('none');
            $table->string('subscriber', 191)->index()->default('none');
            $table->string('uidCreator', 191)->index()->default('none');
            $table->timestamps();

            // Indexes for productCode, qty, and status
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exportProductPrice');
    }
}
