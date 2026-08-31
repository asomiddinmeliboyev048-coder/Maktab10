<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterTeacherIdNullableInSinflarTable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE sinflar MODIFY teacher_id BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE sinflar MODIFY teacher_id BIGINT UNSIGNED NOT NULL');
    }
}