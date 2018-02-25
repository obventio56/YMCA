<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservation_id');
            $table->integer('user_id');
            $table->integer('registration_window')->nullable();
            $table->string('name');
            $table->string('description');
            $table->string('fee')->nullable();
            $table->string('notification_email');
            $table->boolean('public')->default(false);
            $table->integer('available_spots');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
