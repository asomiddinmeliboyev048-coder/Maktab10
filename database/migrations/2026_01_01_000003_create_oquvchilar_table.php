<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOquvchilarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oquvchilar', function (Blueprint $table) {

            $table->bigIncrements('id');

            // Masalan: ST-10045
            $table->string('student_id')->unique();

            // Sinf
            $table->unsignedBigInteger('sinf_id');

            // F.I.O
            $table->string('fio');

            // Telefon
            $table->string('phone')->nullable();

            // Manzil
            $table->text('address')->nullable();

            $table->timestamps();

            /*
             * sinflar jadvali bilan bog'lanish
             */
            $table->foreign('sinf_id')
                ->references('id')
                ->on('sinflar')
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
        Schema::dropIfExists('oquvchilar');
    }
}