<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string('uidCreator')->default('none')->index('uidCreator');
            $table->string('photo_url')->default('none');
            $table->string('name')->default('none');
            $table->string('email')->default('none')->index('email');
            $table->string('password')->default('none');
            $table->string('Ccode')->default('none')->index("Ccode");
            $table->string('phone')->default('none')->index('phone');
            $table->string('initCountry')->default('none');
            $table->string('country')->default('none')->index("country");
            $table->string('PhoneNumber')->default('none')->index("PhoneNumber");

            $table->string('platform')->default('none');
            $table->string('permission')->index('permission')->default('none');
            $table->string('status')->default('none');
            $table->string('CompanyName')->default('none')->index('CompanyName');
            $table->string('subscriber')->default('none')->index("subscriber");//company Name
            $table->string('country')->default('none');
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
        Schema::dropIfExists('admins');
    }
}
