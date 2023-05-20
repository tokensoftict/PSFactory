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

        Schema::table('material_return_items', function (Blueprint $table) {
            $table->decimal('edited_measurement')->default(0)->after('convert_measurement');
        });

        Schema::table('stockopenings', function (Blueprint $table) {
            $table->decimal('pieces')->default(0)->after('quantity');
        });

        Schema::table('rawmaterials', function (Blueprint $table) {
            $table->boolean('divide_by_carton')->default(0)->after('measurement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('material_return_items', function (Blueprint $table) {
            $table->dropColumn('edited_measurement');
        });


        Schema::table('stockopenings', function (Blueprint $table) {
            $table->dropColumn('pieces');
        });

        Schema::table('rawmaterials', function (Blueprint $table) {
            $table->boolean('divide_by_carton')->default(0)->after('measurement');
        });

    }
};
