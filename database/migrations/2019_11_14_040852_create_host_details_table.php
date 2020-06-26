<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('host_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('region_listings_id');
            $table->foreign('region_listings_id')->references('id')->on('region_listings')->onDelete('cascade');
            $table->string('api_id');
            $table->string('userId')->nullable();
            $table->string('name')->nullable();
            $table->text('profileUrl')->nullable();
            $table->text('about')->nullable();
            $table->text('address')->nullable();
            $table->string('memberSince')->nullable();
            $table->string('isVerifiedId')->nullable();
            $table->longText('image')->nullable();
            $table->longText('profileFields')->nullable();
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
        Schema::dropIfExists('host_details');
    }
}
