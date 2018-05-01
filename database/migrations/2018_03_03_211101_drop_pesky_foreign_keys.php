<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPeskyForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('reservations', function (Blueprint $table) {
        $table->dropForeign('reservations_reservation_slot_id_foreign');
      });
      Schema::table('registrations', function (Blueprint $table) {
        $table->dropForeign('registrations_reservation_slot_id_foreign');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
