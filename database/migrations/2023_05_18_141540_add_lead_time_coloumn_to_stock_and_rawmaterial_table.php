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
        Schema::table('stocks', function (Blueprint $table) {
            $table->decimal('lead_time')->default(0)->after('quantity');
        });

        Schema::table('rawmaterials', function (Blueprint $table) {
            $table->decimal('lead_time')->default(0)->after('measurement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn('lead_time');
        });

        Schema::table('rawmaterialbatches', function (Blueprint $table) {
            $table->dropColumn('lead_time');
        });
    }
};
