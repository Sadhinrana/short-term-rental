<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rent_details_id');
            $table->foreign('rent_details_id')->references('id')->on('rent_details')->onDelete('cascade');
            $table->dateTime('date')->nullable();
            $table->dateTime('date_seen')->nullable();
            $table->double('rating')->nullable();
            $table->text('source_URL')->nullable();
            $table->text('description')->nullable();
            $table->string('user_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('reviews');
    }

}
