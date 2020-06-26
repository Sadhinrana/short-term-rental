<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rent_details_id');
            $table->foreign('rent_details_id')->references('id')->on('rent_details')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->text('date_seen')->nullable();
            $table->text('source_URL')->nullable();
            $table->string('currency')->nullable();
            $table->double('amount_min')->nullable();
            $table->double('amount_max')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fees');
    }

}
