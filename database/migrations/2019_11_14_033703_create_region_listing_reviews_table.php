<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionListingReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_listing_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_listings_id');
            $table->foreign('region_listings_id')->references('id')->on('region_listings')->onDelete('cascade');
            $table->integer('api_id');
            $table->longText('comments')->nullable();
            $table->string('commentsResponseDate')->nullable();
            $table->string('reviewer')->nullable();
            $table->string('reviewDate')->nullable();
            $table->longText('reviewerPhoto')->nullable();
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
        Schema::dropIfExists('region_listing_reviews');
    }
}
