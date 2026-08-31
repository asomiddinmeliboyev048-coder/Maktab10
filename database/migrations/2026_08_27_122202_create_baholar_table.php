<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaholarTable extends Migration
{
    public function up()
    {
        Schema::create('baholar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sinf_id');
            $table->unsignedBigInteger('oquvchi_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('fan')->nullable();
            $table->date('sana');
            $table->unsignedTinyInteger('baho'); // 1..5
            $table->text('izoh')->nullable();
            $table->timestamps();

            $table->foreign('sinf_id')->references('id')->on('sinflar')->onDelete('cascade');
            $table->foreign('oquvchi_id')->references('id')->on('oquvchilar')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('baholar');
    }
}