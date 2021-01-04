<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesHooksTable extends Migration
{
    public function up()
    {
        Schema::create('courses_hooks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->string('link')->nullable();
            $table->boolean('priorized')->default(0)->nullable();
            $table->string('educational_level')->nullable();
            $table->boolean('growinghook')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
