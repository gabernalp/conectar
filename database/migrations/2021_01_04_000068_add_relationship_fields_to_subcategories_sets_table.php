<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSubcategoriesSetsTable extends Migration
{
    public function up()
    {
        Schema::table('subcategories_sets', function (Blueprint $table) {
            $table->unsignedBigInteger('resourcessubcategory_id')->nullable();
            $table->foreign('resourcessubcategory_id', 'resourcessubcategory_fk_2827485')->references('id')->on('resources_subcategories');
            $table->unsignedBigInteger('resourcescategory_id')->nullable();
            $table->foreign('resourcescategory_id', 'resourcescategory_fk_2827489')->references('id')->on('resources_categories');
        });
    }
}
