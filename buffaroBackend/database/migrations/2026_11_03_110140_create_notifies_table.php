<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('notify', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->index(); // Action UID (e.g., caisse UID)
            $table->string('status'); // Status from environment variable
            $table->string('permission'); // Permission level/type
            $table->string('notificationType')->default('none'); // Type of notification
            $table->string('notifyApproval')->index()->default('0'); // Approval rule/action (equal, less, greater)
            // $table->integer('notifyCount')->default(0); // Uncomment if you use notifyCount later
            $table->string('subscriber')->index(); // Subscriber identifier from Auth
            $table->string('uidCreator')->index(); // Creator UID from Auth
            $table->string('title'); // Notification title
            $table->text('message'); // Notification message content
            $table->timestamp('created_at')->nullable(); // Explicitly mapped to $this->today
            //$table->index(['subscriber', 'uid','permission','notifyApproval']); // Composite index for efficient lookups
            // Optional: add updated_at if Laravel expects timestamps() by default
            // $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notify');
    }
}
