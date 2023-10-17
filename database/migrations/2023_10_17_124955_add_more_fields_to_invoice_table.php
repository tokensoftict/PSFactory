<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('vehicle_number', 14)->nullable()->after('packed_by');
            $table->string('driver_name', 50)->nullable()->after('packed_by');
            $table->string('driver_phone_number', 13)->nullable()->after('packed_by');
            $table->string('received_by', 50)->nullable()->after('packed_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
};
