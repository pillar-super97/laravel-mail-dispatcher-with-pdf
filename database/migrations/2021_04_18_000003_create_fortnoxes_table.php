<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFortnoxesTable extends Migration
{
    public function up()
    {
        Schema::create('fortnoxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client')->unique();
            $table->string('secret');
            $table->string('access_code')->unique();
            $table->string('access_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
