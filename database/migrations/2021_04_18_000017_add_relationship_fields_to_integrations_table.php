<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToIntegrationsTable extends Migration
{
    public function up()
    {
        Schema::table('integrations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_3664297')->references('id')->on('users');
            $table->unsignedBigInteger('platform_id');
            $table->foreign('platform_id', 'platform_fk_3694310')->references('id')->on('platforms');
        });
    }
}
