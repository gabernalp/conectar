<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFeedbacksUsersTable extends Migration
{
    public function up()
    {
        Schema::table('feedbacks_users', function (Blueprint $table) {
            $table->unsignedBigInteger('feedbacktype_id');
            $table->foreign('feedbacktype_id', 'feedbacktype_fk_2825385')->references('id')->on('feedback_types');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_2825386')->references('id')->on('users');
            $table->unsignedBigInteger('referencetype_id');
            $table->foreign('referencetype_id', 'referencetype_fk_2825388')->references('id')->on('reference_types');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_2825395')->references('id')->on('users');
            $table->unsignedBigInteger('programmed_course_id')->nullable();
            $table->foreign('programmed_course_id', 'programmed_course_fk_2826014')->references('id')->on('course_schedules');
        });
    }
}
