<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained();
            $table->foreignId('package_id')->nullable()->constrained();
            $table->foreignId('agent')->nullable()->constrained('users');
            $table->foreignId('contacted_by')->nullable()->constrained('users');
            $table->string('name');
            $table->string('title');
            $table->string('email');
            $table->string('phone');
            $table->text('message');
            $table->string('status')->nullable();
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
        Schema::dropIfExists('enquiries');
    }
}
