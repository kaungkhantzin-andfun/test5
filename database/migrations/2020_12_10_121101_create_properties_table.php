<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('slug');
            $table->integer('price');
            $table->foreignId('type_id')->constrained('categories');
            $table->foreignId('property_purpose_id')->constrained();
            $table->integer('parking')->nullable();
            $table->string('area')->nullable(); // width x length
            $table->integer('beds')->nullable();
            $table->integer('baths')->nullable();
            $table->datetime('featured')->nullable();
            $table->datetime('featured_expiry')->nullable();
            $table->text('installment')->nullable();
            $table->integer('stat')->nullable();
            $table->date('soldout')->nullable();
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
        Schema::dropIfExists('properties');
    }
}
