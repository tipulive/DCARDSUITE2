<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up(): void
    {
        Schema::create('userAccount', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 191);
            $table->string('status', 191)->default('active');
            $table->string('currency', 191)->default('none');
            $table->string('subscriber', 191);

            // Financial and balance columns as VARCHAR(191) with default '0'
            $table->string('safeBalance', 191)->default('0');
            $table->string('bonus', 191)->default('0');
            $table->string('balance', 191)->default('0');
            $table->string('balanceSent', 191)->default('0');
            $table->string('dettes', 191)->default('0');
            $table->string('promoAmount', 191)->default('0');
            $table->string('promoAsset', 191)->default('0')->nullable();
            $table->string('proAssetQty', 191)->default('0');
            $table->string('outPromoAmount', 191)->default('0');
            $table->string('outPromoAsset', 191)->default('0')->nullable();
            $table->string('outProAssetQty', 191)->default('0');

            $table->timestamps();

            // Composite index for lookups
            $table->index(['uid', 'currency', 'status','subscriber']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('userAccount');
    }
}
