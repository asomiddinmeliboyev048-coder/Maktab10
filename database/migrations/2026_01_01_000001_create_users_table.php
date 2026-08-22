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

            $table->bigIncrements('id');

            $table->string('name');

            $table->string('email')->unique();

            $table->string('password');

            // Profil rasmi
            $table->string('avatar')->nullable();

            // Foydalanuvchi roli
            $table->enum('role', [
                'director',
                'teacher'
            ])->default('teacher');

            // O'qituvchining fani
            $table->string('subject')->nullable();

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