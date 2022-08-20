<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGmailpasswordToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
        $table->string('gmail_password')->nullable();
        });
    }
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('gmail_password');
        });
    }

}
