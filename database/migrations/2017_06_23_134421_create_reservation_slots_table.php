<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_slots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('primary_email');
            $table->string('notification_emails');
            $table->integer('location_id');
            $table->integer('reservation_window');
            $table->string('max_time');
            $table->string('time_interval');
            $table->string('hours_of_operation');
            $table->string('notes');
            $table->string('title');
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
        Schema::dropIfExists('reservation_slots');
    }
}
