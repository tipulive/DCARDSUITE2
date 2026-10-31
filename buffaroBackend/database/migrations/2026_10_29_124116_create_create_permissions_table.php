<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up(): void
    {
        // 1. Create 'permissions' table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('name');
            $table->string('status');
            $table->text('description')->nullable();
            $table->string('subscriber');
            $table->string('uidCreator');
            $table->timestamps();

            // Indexes for fast lookups used in your queries
            $table->index(['subscriber', 'uid', 'status']);
        });

        // 2. Create 'permissionAdded' table
        Schema::create('permissionAdded', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('uidUser');
            $table->string('status');
            $table->string('uidCreator');
            $table->string('subscriber');
            $table->timestamps();

            // Indexes for fast lookups used in checkPermssionAdded()
            $table->index(['subscriber', 'uid']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissionAdded');
        Schema::dropIfExists('permissions');
    }
}
