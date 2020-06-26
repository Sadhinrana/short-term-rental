<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('rent_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rent_id')->nullable();
            $table->text('address')->nullable();
            $table->dateTime('available_date')->nullable();
            $table->string('brokers')->nullable();
            $table->string('building_name')->nullable();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->dateTime('date_added')->nullable();
            $table->dateTime('date_updated')->nullable();
            $table->text('floor_size_value')->nullable();
            $table->text('floor_size_unit')->nullable();
            $table->string('geo_location')->nullable();
            $table->string('hours')->nullable();
            $table->text('image_url')->nullable();
            $table->string('key')->nullable();
            $table->string('languages_spoken')->nullable();
            $table->string('latitude')->nullable();
            $table->string('leasing_terms')->nullable();
            $table->string('listing_name')->nullable();
            $table->string('longitude')->nullable();
            $table->string('lot_size_value')->nullable();
            $table->string('lot_size_unit')->nullable();
            $table->string('managed_by')->nullable();
            $table->string('most_recent_status')->nullable();
            $table->dateTime('most_recent_status_date')->nullable();
            $table->string('mls_number')->nullable();
            $table->string('near_by_school')->nullable();
            $table->string('neighborhood')->nullable();
            $table->double('num_bathroom')->nullable();
            $table->double('num_bedroom')->nullable();
            $table->double('num_floor')->nullable();
            $table->double('num_people')->nullable();
            $table->double('num_room')->nullable();
            $table->double('num_unit')->nullable();
            $table->string('parking')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('pet_policy')->nullable();
            $table->string('phones')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('property_tax')->nullable();
            $table->string('property_type')->nullable();
            $table->string('province')->nullable();
            $table->text('rules')->nullable();
            $table->text('source_URL')->nullable();
            $table->string('tax_ID')->nullable();
            $table->dateTime('unavailable_date')->nullable();
            $table->string('website_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('rent_details');
    }

}
