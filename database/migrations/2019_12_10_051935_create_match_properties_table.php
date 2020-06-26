<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('masterPropertyID');
            $table->integer('nooPropertyID');
            $table->text('masterPropertyTitle')->nullable();
            $table->text('nooPropertyTitle')->nullable();
            $table->double('masterPropertylat');
            $table->double('masterPropertylng');
            $table->double('nooPropertyLat');
            $table->double('nooPropertylng');
            $table->integer('vote');
            $table->integer('user_id');
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
        Schema::dropIfExists('match_properties');
    }
}
