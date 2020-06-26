<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->string('SiteAddress')->nullable();
            $table->string('SiteUnit')->nullable();
            $table->string('SiteCity')->nullable();
            $table->string('SiteState')->nullable();
            $table->string('SiteZipCode')->nullable();
            $table->string('SiteNeighborhood')->nullable();
            $table->string('SiteStreetNumber')->nullable();
            $table->string('SiteStreetPreDir')->nullable();
            $table->string('SiteStreetName')->nullable();
            $table->string('SiteStreetType')->nullable();
            $table->string('SiteStreetPostDir')->nullable();
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
        Schema::dropIfExists('sites');
    }
}
