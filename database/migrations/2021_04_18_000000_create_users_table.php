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
            $table->string('name');
            $table->string('gender');
            $table->string('birthday');
            $table->bigInteger('svnr')->unique();
            $table->bigInteger('phonenumber')->unique();
            $table->boolean('is_vaccinated')->default(false);
            $table->string('email');
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            $table->foreignId('vaccination_id')->nullable()->constrained()->onDelete('cascade');
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
