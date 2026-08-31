<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddStaffFieldsToUsersTableV2 extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'staff_id')) {
                $table->string('staff_id')->nullable()->unique()->after('id');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('subject');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('phone');
            }
        });

        /*
        |--------------------------------------------------------------------------
        | "role" ENUM ustuniga 'deputy' (direktor o'rinbosari) qiymatini qo'shish
        |--------------------------------------------------------------------------
        */

        DB::statement(
            "ALTER TABLE users MODIFY COLUMN role ENUM('director','teacher','deputy') NOT NULL DEFAULT 'teacher'"
        );
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'staff_id')) {
                $table->dropColumn('staff_id');
            }

            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
        });

        DB::statement(
            "ALTER TABLE users MODIFY COLUMN role ENUM('director','teacher') NOT NULL DEFAULT 'teacher'"
        );
    }
}