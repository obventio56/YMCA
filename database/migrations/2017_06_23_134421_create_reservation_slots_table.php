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
            $table->string('description')->nullable();
            $table->string('primary_email');
            $table->string('notification_emails')->nullable();
            $table->integer('location_id');
            $table->integer('user_id');
            $table->integer('reservation_window');
            $table->integer('max_time');
            $table->integer('time_interval');
            $table->string('hours_of_operation');
            $table->string('notes')->nullable();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
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
