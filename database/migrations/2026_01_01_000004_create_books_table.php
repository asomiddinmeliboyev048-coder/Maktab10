<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {

            $table->bigIncrements('id');

            // Kitob nomi
            $table->string('title');

            // Kitob kodi / shtrix-kod
            $table->string('code')->unique()->nullable();

            // Muallif
            $table->string('author')->nullable();

            // Umumiy nusxalar
            $table->integer('total_copies')->default(1);

            // Hozir mavjud nusxalar
            $table->integer('available_copies')->default(1);

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
        Schema::dropIfExists('books');
    }
}