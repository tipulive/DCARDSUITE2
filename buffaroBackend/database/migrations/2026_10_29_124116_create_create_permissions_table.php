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
            $table->string('uid')->index();
            $table->string('name');
            $table->string('status')->index();
            $table->text('description')->nullable();
            $table->string('subscriber')->index();
            $table->string('uidCreator');
            $table->timestamps();

            // Indexes for fast lookups used in your queries
           // $table->index(['subscriber', 'uid', 'status']);
        });

        // 2. Create 'permissionAdded' table
        Schema::create('permissionAdded', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index();
            $table->string('uidUser');
            $table->string('status');
            $table->string('uidCreator');
            $table->string('subscriber')->index();
            $table->timestamps();

            // Indexes for fast lookups used in checkPermssionAdded()
            ////$table->index(['subscriber', 'uid', 'uidUser', 'status','permissions']);
        });
        Schema::create('permissionACtion', function (Blueprint $table) {
            $table->id();
            $table->string('action')->index(); // Action name (e.g., createCaisse)
            $table->text('permission')->index(); // JSON or string storing permissions structure
            $table->string('status')->index(); // Status from environment variable
            $table->string('uidCreator'); // Creator UID from Auth
            $table->string('subscriber')->index(); // Subscriber identifier from Auth
           $table->timestamps();
            // Optional: performance indexes for your raw SQL WHERE clause
            //$table->index(['action', 'subscriber', 'status','permission']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissionAdded');
        Schema::dropIfExists('permissions');
    }
}
