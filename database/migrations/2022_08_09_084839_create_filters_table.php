<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->string('mailto');
            $table->boolean('pdfFromBody')->default(0);
            $table->boolean('logo')->default(0);
            $table->boolean('profile')->default(0);
            $table->boolean('allowEmptyContent')->default(0);
            $table->boolean('multipleJpgIntoPdf')->default(0);
            $table->boolean('sizeLimit')->default(0);
            $table->integer('minSize')->default(0);
            $table->integer('maxSize')->default(700);
            $table->integer('sizeUnit')->default(0);
            $table->boolean('extensionLimit')->default(0);
            $table->string('exExtension')->default('');
            $table->boolean('wordLimit')->default(0);
            $table->string('inWord')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filters');
    }
}
