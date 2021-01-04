<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgeCoursesUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('badge_courses_user', function (Blueprint $table) {
            $table->unsignedBigInteger('courses_user_id');
            $table->foreign('courses_user_id', 'courses_user_id_fk_2829669')->references('id')->on('courses_users')->onDelete('cascade');
            $table->unsignedBigInteger('badge_id');
            $table->foreign('badge_id', 'badge_id_fk_2829669')->references('id')->on('badges')->onDelete('cascade');
        });
    }
}
