<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_id');
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->integer('api_id');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('profileUrl')->nullable();
            $table->string('hostName')->nullable();
            $table->string('dateCrawled')->nullable();
            $table->integer('numReviews')->nullable();
            $table->string('externalId')->nullable();
            $table->text('description')->nullable();
            $table->string('currencySymbol')->nullable();
            $table->string('hostId')->nullable();
            $table->string('source')->nullable();
            $table->string('userId')->nullable();
            $table->integer('personCapacity')->nullable();
            $table->integer('totalImages')->nullable();
            $table->integer('minNights')->nullable();
            $table->text('aboutTheHost')->nullable();
            $table->double('price')->nullable();
            $table->text('detailedAddress')->nullable();
            $table->string('name')->nullable();
            $table->text('listingUrl')->nullable();
            $table->text('aboutTheListing')->nullable();
            $table->string('currency')->nullable();
            $table->string('roomType')->nullable();
            $table->tinyInteger('flag')->default(0);
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
        Schema::dropIfExists('region_listings');
    }
}
