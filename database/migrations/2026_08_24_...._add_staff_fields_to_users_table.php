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
            */
            if (!Schema::hasColumn('users', 'staff_id')) {
                $table->string('staff_id', 50)
                    ->nullable()
                    ->unique();
            }

            /*
            |--------------------------------------------------------------------------
            | Login
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('users', 'login')) {
                $table->string('login', 100)
                    ->nullable()
                    ->unique();
            }

            /*
            |--------------------------------------------------------------------------
            | Asosiy fan
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('users', 'subject')) {
                $table->string('subject', 255)
                    ->nullable();
            }

            /*
            |--------------------------------------------------------------------------
            | Telefon
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 50)
                    ->nullable();
            }

            /*
            |--------------------------------------------------------------------------
            | Manzil
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')
                    ->nullable();
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

            if (Schema::hasColumn('users', 'staff_id')) {
                $table->dropUnique('users_staff_id_unique');
            }

            if (Schema::hasColumn('users', 'login')) {
                $table->dropUnique('users_login_unique');
            }

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
