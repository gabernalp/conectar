<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_2719158')->references('id')->on('departments');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id', 'city_fk_2719159')->references('id')->on('cities');
            $table->unsignedBigInteger('documenttype_id')->nullable();
            $table->foreign('documenttype_id', 'documenttype_fk_2723029')->references('id')->on('document_types');
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->foreign('operator_id', 'operator_fk_2825258')->references('id')->on('operators');
        });
    }
}
