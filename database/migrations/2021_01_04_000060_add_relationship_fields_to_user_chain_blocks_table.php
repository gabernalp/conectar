<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserChainBlocksTable extends Migration
{
    public function up()
    {
        Schema::table('user_chain_blocks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_2885894')->references('id')->on('users');
            $table->unsignedBigInteger('referencetype_id')->nullable();
            $table->foreign('referencetype_id', 'referencetype_fk_2885895')->references('id')->on('reference_types');
        });
    }
}
