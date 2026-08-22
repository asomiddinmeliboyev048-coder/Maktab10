<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinflarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinflar', function (Blueprint $table) {

            $table->bigIncrements('id');

            // Masalan: 9-A
            $table->string('name');

            // Sinf rahbari
            $table->unsignedBigInteger('teacher_id');

            $table->string('room')->nullable();

            $table->timestamps();

            /*
             * users jadvali bilan bog'lanish
             */
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sinflar');
    }
}