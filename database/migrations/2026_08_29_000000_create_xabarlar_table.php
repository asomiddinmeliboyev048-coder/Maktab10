<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXabarlarTable extends Migration
{
    public function up()
    {
        Schema::create('xabarlar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sinf_id');
            $table->unsignedBigInteger('teacher_id');
            $table->date('sana');
            // 'davomat' yoki 'baho' — o'qituvchi qaysi amalni bajarganini bildiradi
            $table->string('turi', 10);
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('sinf_id')->references('id')->on('sinflar')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');

            // Bir o'qituvchi bir sinfga bir kunda bir turdagi amalni bir marta "xabar" sifatida yozadi;
            // qayta saqlasa, faqat vaqti (updated_at) yangilanadi — dublikat qatorlar yaratilmaydi.
            $table->unique(['sinf_id', 'teacher_id', 'sana', 'turi'], 'xabar_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('xabarlar');
    }
}