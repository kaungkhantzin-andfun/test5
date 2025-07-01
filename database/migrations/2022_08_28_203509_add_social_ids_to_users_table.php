<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook_user_id')->after('password')->nullable();
            $table->string('google_user_id')->after('password')->nullable();
            $table->string('twitter_user_id')->after('password')->nullable();
            $table->string('linkedin_user_id')->after('password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('facebook_user_id');
            $table->dropColumn('google_user_id');
            $table->dropColumn('twitter_user_id');
            $table->dropColumn('linkedin_user_id');
        });
    }
};
