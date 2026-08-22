<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_issues', function (Blueprint $table) {

            $table->bigIncrements('id');

            // O'quvchi
            $table->unsignedBigInteger('oquvchi_id');

            // Kitob
            $table->unsignedBigInteger('book_id');

            // Berilgan sana
            $table->date('given_date');

            // Qaytarilgan sana
            $table->date('return_date')->nullable();

            // Kitob holati
            $table->enum('status', [
                'olgan',
                'topshirgan'
            ])->default('olgan');

            $table->timestamps();

            /*
             * O'quvchi bilan bog'lanish
             */
            $table->foreign('oquvchi_id')
                ->references('id')
                ->on('oquvchilar')
                ->onDelete('cascade');

            /*
             * Kitob bilan bog'lanish
             */
            $table->foreign('book_id')
                ->references('id')
                ->on('books')
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
        Schema::dropIfExists('book_issues');
    }
}