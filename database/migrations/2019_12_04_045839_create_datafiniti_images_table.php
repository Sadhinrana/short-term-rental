<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatafinitiImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datafiniti_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rent_id');
            $table->foreign('rent_id')->references('id')->on('rent_details')->onDelete('cascade');
            $table->text('image_link')->nullable();
            $table->text('image')->nullable();
            $table->longText('image_object')->nullable();
            $table->longText('image_labels')->nullable();
            $table->longText('image_text')->nullable();
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
        Schema::dropIfExists('datafiniti_images');
    }
}
