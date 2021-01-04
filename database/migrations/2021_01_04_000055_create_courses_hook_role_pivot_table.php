<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesHookRolePivotTable extends Migration
{
    public function up()
    {
        Schema::create('courses_hook_role', function (Blueprint $table) {
            $table->unsignedBigInteger('courses_hook_id');
            $table->foreign('courses_hook_id', 'courses_hook_id_fk_2826200')->references('id')->on('courses_hooks')->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_2826200')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
