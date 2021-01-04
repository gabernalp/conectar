<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToChallengesUsersTable extends Migration
{
    public function up()
    {
        Schema::table('challenges_users', function (Blueprint $table) {
            $table->unsignedBigInteger('challenge_id')->nullable();
            $table->foreign('challenge_id', 'challenge_fk_2826247')->references('id')->on('challenges');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2826249')->references('id')->on('users');
            $table->unsignedBigInteger('referencetype_id')->nullable();
            $table->foreign('referencetype_id', 'referencetype_fk_2826250')->references('id')->on('reference_types');
        });
    }
}
