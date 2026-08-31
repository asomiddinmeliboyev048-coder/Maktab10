<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDavomatlarTable extends Migration
{
    public function up()
    {
        Schema::create('davomatlar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sinf_id');
            $table->unsignedBigInteger('oquvchi_id');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->date('sana');
            // keldi, sz (sababsiz), sb (sababli), kq (kelgan-qatnashmagan), kc (kechikkan)
            $table->string('status', 5)->default('keldi');
            $table->text('izoh')->nullable();
            $table->timestamps();

            $table->unique(['oquvchi_id', 'sana'], 'davomat_oquvchi_sana_unique');

            $table->foreign('sinf_id')->references('id')->on('sinflar')->onDelete('cascade');
            $table->foreign('oquvchi_id')->references('id')->on('oquvchilar')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('davomatlar');
    }
}