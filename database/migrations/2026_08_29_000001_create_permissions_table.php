<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('module');       // students, classes, teachers, ...
            $table->string('module_name');  // O'quvchilar, Sinflar, ...
            $table->string('action');       // view, create, edit, delete
            $table->string('slug')->unique(); // students.view
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}