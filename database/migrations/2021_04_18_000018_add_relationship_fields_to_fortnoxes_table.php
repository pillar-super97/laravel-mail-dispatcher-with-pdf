<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFortnoxesTable extends Migration
{
    public function up()
    {
        Schema::table('fortnoxes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_3694240')->references('id')->on('users');
        });
    }
}
