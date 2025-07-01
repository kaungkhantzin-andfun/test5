<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('role')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->foreignId('service_region_id')->nullable();
            // type is string coz we will accept multiple ids and store the serialized version
            // and cannot use many to many relation since we don't want to make database more complex
            $table->text('service_township_id')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->string('social_pages')->nullable();
            $table->date('partner')->nullable(); // partnered or not (higher than featured)
            $table->date('featured')->nullable(); // featured or not 
            $table->string('credit')->nullable();
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
        Schema::dropIfExists('users');
    }
}
