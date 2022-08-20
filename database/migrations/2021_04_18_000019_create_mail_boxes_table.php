<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailBoxesTable extends Migration
{
    public function up()
    {
        Schema::create('mail_boxes', function (Blueprint $table) {
            $table->id();
            $table->integer('uid');
            $table->text('subject')->default('');
            $table->text('from_email')->default('');
            $table->text('body')->default('');
            $table->text('attachments_path')->nullable();
            $table->boolean('state')->default(false);
            $table->timestamps();
        });
    }
}
