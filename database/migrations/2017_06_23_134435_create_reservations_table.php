<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->boolean('for_event')->default(false);
            $table->integer('reservation_slot_id');
            $table->integer('user_id');
            $table->string('notes')->nullable();
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('reservation_slot_id')->references('id')->on('reservation_slot')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
