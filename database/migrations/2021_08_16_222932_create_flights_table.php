<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plane_id')->constrained('planes')->onDelete('cascade');
            $table->foreignId('pilot_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('departure_airport')->constrained('airports')->onDelete('cascade');
            $table->foreignId('arrival_airport')->constrained('airports')->onDelete('cascade');
            $table->string('departure_date');
            $table->string('arrival_date');
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
        Schema::dropIfExists('flights');
    }
}
