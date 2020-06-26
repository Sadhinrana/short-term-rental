<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionListingImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_listing_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_listings_id');
            $table->foreign('region_listings_id')->references('id')->on('region_listings')->onDelete('cascade');
            $table->integer('api_id');
            $table->string('caption')->nullable();
            $table->integer('index')->nullable();
            $table->string('extension')->nullable();
            $table->longText('image')->nullable();
            $table->text('thumbnail')->nullable();
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
        Schema::dropIfExists('region_listing_images');
    }
}
