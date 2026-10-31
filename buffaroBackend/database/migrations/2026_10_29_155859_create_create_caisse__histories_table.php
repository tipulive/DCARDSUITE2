<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateCaisseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  public function up(): void
    {
        // 1. reqCaisse Table Schema
        Schema::create('reqCaisse', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 191);              // Indexed for lookups & updates (`where uid=:uid`)
            $table->string('status', 191)->default('0');           // Indexed for filtering by status
            $table->string('purpose', 191)->default('none');
            $table->string('source', 191)->default('none');
            $table->string('commentData', 191)->default('none');
            $table->string('subscriber', 191);       // Indexed for multi-tenant filtering (`subscriber=:subscriber`)
            $table->string('uidReq', 191)->default('none');      // Requester UID
            $table->string('uidApprove', 191)->nullable();
            $table->string('approvalVote', 191)->default('0');
            $table->integer('voter')->default(0);          // Used in raw update: voter + :vote
            $table->integer('votingCount')->default(0);     // Used in raw update: votingCount + :votingCount
            $table->string('amount', 191);                  // Replaced decimal with varchar(191)
            $table->string('currency', 191);
            $table->timestamps();

            // Composite index for your update query WHERE clause: where uid=:uid and subscriber=:subscriber
$table->index(['uid', 'subscriber', 'status', 'uidReq', 'uidApprove', 'approvalVote','currency','source']);
        });

        // 2. reqCaisseHistory Table Schema
        Schema::create('reqCaisseHistory', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 191)->index();              // Indexed for lookups
            $table->string('actionName', 191);
            $table->string('status', 191)->index();
            $table->string('commentData', 191)->default('none');
            $table->string('subscriber', 191)->index();       // Indexed for tenant filtering
            $table->string('uidReq', 191)->default('none');
            $table->string('uidApprove', 191);
            $table->string('approvalVote', 191);
            $table->string('voting', 191);
            $table->string('amount', 191);                  // Replaced decimal with varchar(191)
            $table->string('currency', 191);
            $table->string('cAmount', 191)->default('0');   // Replaced decimal with varchar(191)
            $table->string('cCurrency', 191)->default('none');
            $table->timestamps();
             $table->index(['uid', 'subscriber','uidReq','approvalVote','currency','uidApprove']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reqCaisseHistory');
        Schema::dropIfExists('reqCaisse');
    }
}
