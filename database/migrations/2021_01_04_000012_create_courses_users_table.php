<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesUsersTable extends Migration
{
    public function up()
    {
        Schema::create('courses_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group')->nullable();
            $table->date('end_date');
            $table->string('challenges');
            $table->string('course_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
