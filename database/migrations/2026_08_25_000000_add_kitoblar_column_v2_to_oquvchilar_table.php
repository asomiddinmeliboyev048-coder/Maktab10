<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKitoblarColumnV2ToOquvchilarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oquvchilar', function (Blueprint $table) {

            // Berilgan/berilmagan darsliklar ro'yxati JSON ko'rinishida saqlanadi
            $table->text('kitoblar')
                ->nullable()
                ->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oquvchilar', function (Blueprint $table) {
            $table->dropColumn('kitoblar');
        });
    }
}
