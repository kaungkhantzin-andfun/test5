<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ref: https://laravel-news.com/how-to-add-multilingual-support-to-eloquent
        Schema::create('property_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id');
            $table->string('locale')->index();

            $table->string('title');
            $table->longText('detail');
            $table->text('address')->nullable();

            $table->unique(['property_id', 'locale']);
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_translations');
    }
}
