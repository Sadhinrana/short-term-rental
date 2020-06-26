<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageObjectToRegionListingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('region_listing_images', function (Blueprint $table) {
            $table->longText('image_object')->nullable()->after('image');
            $table->longText('image_labels')->nullable()->after('image_object');
            $table->longText('image_text')->nullable()->after('image_labels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('region_listing_images', function (Blueprint $table) {
            //
        });
    }
}
