<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostGuestReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('host_guest_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_listings_id');
            $table->foreign('region_listings_id')->references('id')->on('region_listings')->onDelete('cascade');
            $table->string('api_id');
            $table->string('fromHostUrl')->nullable();
            $table->string('fromHostName')->nullable();
            $table->string('createdOn')->nullable();
            $table->string('relationship')->nullable();
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('host_guest_reviews');
    }
}
