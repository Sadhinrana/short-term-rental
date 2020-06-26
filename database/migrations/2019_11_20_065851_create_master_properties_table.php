<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('URL')->nullable();
            $table->text('listing_name')->nullable();
            $table->string('room_type')->nullable();
            $table->string('floor_size_value')->nullable();
            $table->string('floor_size_unit')->nullable();
            $table->double('price')->nullable();
            $table->text('address')->nullable();
            $table->integer('no_of_people')->nullable();
            $table->integer('no_of_bathroom')->nullable();
            $table->integer('num_bedroom')->nullable();
            $table->integer('num_floor')->nullable();
            $table->integer('num_room')->nullable();
            $table->integer('rent_details_id')->nullable();
            $table->integer('region_listings_id')->nullable();
            $table->string('data_source')->nullable();
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
        Schema::dropIfExists('master_properties');
    }
}
