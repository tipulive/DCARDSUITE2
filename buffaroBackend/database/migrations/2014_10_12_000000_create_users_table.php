<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->String('carduid')->index('carduid');
            $table->string('uidCreator')->index('uidCreator');
           // $table->string('uidAssign')->index("uidAssign")->default("none");//who assign Card
            $table->string('subscriber')->default('none')->index("subscriber");//company Name
            $table->string('photo_url')->default('none');
            $table->string('name')->default('none');
            $table->string('email')->default('none');
            $table->string('password')->default('none');
            $table->string('Ccode')->default('none');
            $table->string('phone')->default('none');
            $table->string('PhoneNumber')->default('none')->index("PhoneNumber");

            $table->string('platform')->default('none')->index("platform");
            $table->string('status')->default('none')->index("gender");
            $table->string('gender')->default('none')->index("status");
            $table->string('age')->default('none')->index("age");


            $table->string('initCountry')->default('none');
            $table->string('country')->default('none')->index("country");
            $table->string('marital_status')->default('none')->index("marital_status");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
