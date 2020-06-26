<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->unsignedBigInteger('OwnerId');
            $table->foreign('OwnerId')->references('Id')->on('owners')->onDelete('cascade');
            $table->unsignedBigInteger('SiteId');
            $table->foreign('SiteId')->references('Id')->on('sites')->onDelete('cascade');
            $table->string('PropertyGID')->nullable();
            $table->string('ParcelID')->nullable();
            $table->string('ParcelLong')->nullable();
            $table->string('TaxAccount')->nullable();
            $table->string('ParcelCity')->nullable();
            $table->string('LegalDesc')->nullable();
            $table->string('X_DD')->nullable();
            $table->string('Y_DD')->nullable();
            $table->string('GeoType')->nullable();
            $table->string('PropertyUse')->nullable();
            $table->string('ActiveFlag')->nullable();
            $table->string('CommCommunityID')->nullable();
            $table->string('IDX_Address')->nullable();
            $table->string('NumberofUnits')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('properties');
    }
}
