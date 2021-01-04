<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelfInterestedUsersTable extends Migration
{
    public function up()
    {
        Schema::create('self_interested_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('contact')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
