<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Xodim ID raqami
            |--------------------------------------------------------------------------
            |
            | Direktor, direktor o‘rinbosari va o‘qituvchilarga
            | avtomatik ID biriktirish uchun.
            |
            */
            if (!Schema::hasColumn('users', 'staff_id')) {
                $table->string('staff_id', 50)
                    ->nullable()
                    ->unique()
                    ->after('id');
            }

            /*
            |--------------------------------------------------------------------------
            | Login
            |--------------------------------------------------------------------------
            |
            | O‘qituvchi va boshqa xodimlarning tizimga
            | login orqali kirishi uchun.
            |
            */
            if (!Schema::hasColumn('users', 'login')) {
                $table->string('login', 100)
                    ->nullable()
                    ->unique()
                    ->after('email');
            }

            /*
            |--------------------------------------------------------------------------
            | Asosiy fan
            |--------------------------------------------------------------------------
            |
            | O‘qituvchining asosiy fani.
            |
            */
            if (!Schema::hasColumn('users', 'subject')) {
                $table->string('subject', 255)
                    ->nullable()
                    ->after('login');
            }

            /*
            |--------------------------------------------------------------------------
            | Telefon
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 50)
                    ->nullable()
                    ->after('subject');
            }

            /*
            |--------------------------------------------------------------------------
            | Manzil
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')
                    ->nullable()
                    ->after('phone');
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | Unique indexlarni avval olib tashlaymiz
            |--------------------------------------------------------------------------
            */

            if (Schema::hasColumn('users', 'staff_id')) {
                $table->dropUnique('users_staff_id_unique');
            }

            if (Schema::hasColumn('users', 'login')) {
                $table->dropUnique('users_login_unique');
            }

            /*
            |--------------------------------------------------------------------------
            | Ustunlarni olib tashlash
            |--------------------------------------------------------------------------
            */

            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }

            if (Schema::hasColumn('users', 'subject')) {
                $table->dropColumn('subject');
            }

            if (Schema::hasColumn('users', 'login')) {
                $table->dropColumn('login');
            }

            if (Schema::hasColumn('users', 'staff_id')) {
                $table->dropColumn('staff_id');
            }

        });
    }
}