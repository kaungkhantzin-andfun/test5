<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchIndexes extends Migration
{
    private $tbl_names = ['categories', 'property_purposes', 'locations'];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tbl_names as $name) {
            Schema::table($name, function (Blueprint $table) use ($name) {
                // $table->index('slug', $name . '_slug_index');
                $table->unique('slug', $name . '_slug_unique');
            });
        }

        Schema::table('properties', function (Blueprint $table) {
            $table->index('price', 'properties_price_index');
        });

        Schema::table('categorizables', function (Blueprint $table) {
            $table->index(['category_id', 'categorizable_id', 'categorizable_type'], 'categorizable_index');
        });

        Schema::table('location_property', function (Blueprint $table) {
            $table->index(['location_id', 'property_id'], 'location_property_index');
        });

        Schema::table('savables', function (Blueprint $table) {
            $table->index(['user_id', 'savable_id', 'savable_type'], 'savables_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tbl_names as $name) {
            Schema::table($name, function (Blueprint $table) use ($name) {
                // $table->dropIndex($name . '_slug_index');
                $table->dropUnique($name . '_slug_unique');
            });
        }

        // remove the index from the properties table
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex('properties_price_index');
        });
        Schema::table('categorizables', function (Blueprint $table) {
            $table->dropIndex('categorizable_index');
        });

        Schema::table('location_property', function (Blueprint $table) {
            $table->dropIndex('location_property_index');
        });

        Schema::table('savables', function (Blueprint $table) {
            $table->dropIndex('savables_index');
        });
    }
}
