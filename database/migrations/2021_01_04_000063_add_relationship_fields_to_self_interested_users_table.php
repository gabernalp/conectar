<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSelfInterestedUsersTable extends Migration
{
    public function up()
    {
        Schema::table('self_interested_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2841125')->references('id')->on('users');
            $table->unsignedBigInteger('coursehook_id')->nullable();
            $table->foreign('coursehook_id', 'coursehook_fk_2841126')->references('id')->on('courses_hooks');
        });
    }
}
