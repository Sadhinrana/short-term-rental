<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->string('OwnerName1')->nullable();
            $table->string('OwnerName2')->nullable();
            $table->string('OwnerAddress')->nullable();
            $table->string('OwnerCity')->nullable();
            $table->string('OwnerState')->nullable();
            $table->string('OwnerZipcode')->nullable();
            $table->string('OwnerStreetNumber')->nullable();
            $table->string('OwnerStreetPreDir')->nullable();
            $table->string('OwnerStreetName')->nullable();
            $table->string('OwnerStreetType')->nullable();
            $table->string('OwnerStreetPostDir')->nullable();
            $table->string('OwnerUnit')->nullable();
            $table->string('OwnerOccupiedFlag')->nullable();
            $table->string('OwnerOccupiedCode')->nullable();
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
        Schema::dropIfExists('owners');
    }
}
