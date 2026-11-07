<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateSpendingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up(): void
    {
        // 1. reqSpending Table Schema
        Schema::create('reqSpending', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 191)->index();
            $table->string('status', 191)->index();           // Indexed for filtering by status
            $table->string('purpose', 191)->default('none');
            $table->string('source', 191)->default('none');
            $table->string('commentData', 191)->default('none');
            $table->string('subscriber', 191)->index();
            $table->string('uidReq', 191);
            $table->string('img_url', 191)->default('none');
            $table->string('approvalVote', 191)->default('0');
            $table->string('uidApprove', 191)->index()->default('none');
            $table->integer('voter')->default(0);          // Used in raw update: voter + :vote
            $table->integer('votingCount')->index()->default(0);     // Used in raw update: votingCount + :votingCount
            $table->string('amount', 191);                  // Replaced decimal with varchar(191)
            $table->string('currency', 191)->index();
            $table->timestamps();

            // Composite index for your update query WHERE clause: where uid=:uid and subscriber=:subscriber
           // $table->index(['uid', 'subscriber','uidReq','approvalVote','currency','uidApprove']);
        });

        // 2. reqSpendingHistory Table Schema
        Schema::create('reqSpendingHistory', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 191)->index();              // Indexed for lookups
            $table->string('status', 191)->index();           // Indexed for filtering
            $table->string('purpose', 191)->default('none');
            $table->string('source', 191)->default('none');
            $table->string('commentData', 191)->default('none');
            $table->string('subscriber', 191)->index();       // Indexed for tenant filtering
            $table->string('uidApprove', 191);
            $table->string('voting', 191)->default('none');
            $table->string('img_url', 191)->default('none');
            $table->string('amount', 191);                  // Replaced decimal with varchar(191)
            $table->string('currency', 191);
            $table->timestamps();
            // $table->index(['uid','subscriber','uidReq','approvalVote','currency','uidApprove'], 'custom_idx_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reqSpendingHistory');
        Schema::dropIfExists('reqSpending');
    }
}
