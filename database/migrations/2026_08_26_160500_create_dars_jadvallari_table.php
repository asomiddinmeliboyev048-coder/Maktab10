<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDarsJadvallariTable extends Migration
{
    public function up()
    {
        Schema::create('dars_jadvallari', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sinf_id')->nullable();
            $table->string('sinf_name')->nullable();
            $table->unsignedBigInteger('oqituvchi_id')->nullable();
            $table->string('oqituvchi_ism')->nullable();
            $table->string('kun');
            $table->integer('tartib')->default(1);
            $table->string('dars_raqami')->nullable();
            $table->string('vaqti')->nullable();
            $table->string('fan')->nullable();
            $table->timestamps();

            $table->foreign('sinf_id')->references('id')->on('sinflar')->onDelete('set null');
            $table->foreign('oqituvchi_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dars_jadvallari');
    }
}