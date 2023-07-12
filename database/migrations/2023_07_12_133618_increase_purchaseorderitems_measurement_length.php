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
        Schema::table('purchaseorderitems', function (Blueprint $table) {
            $table->decimal("measurement",20,5)->change();
        });

        Schema::table('rawmaterialopenings', function (Blueprint $table) {
            $table->decimal("measurement",20,5)->change();
        });

        Schema::table('nearoutofmaterials', function (Blueprint $table) {
            $table->decimal("quantity",20,5)->change();
            $table->decimal("used",20,5)->change();
        });

        Schema::table('material_return_items', function (Blueprint $table) {
            $table->decimal("edited_measurement",20,5)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchaseorderitems', function (Blueprint $table) {
            $table->decimal("measurement",8,2)->change();
        });

        Schema::table('rawmaterialopenings', function (Blueprint $table) {
            $table->decimal("measurement",8,2)->change();
        });

        Schema::table('nearoutofmaterials', function (Blueprint $table) {
            $table->decimal("quantity",8,2)->change();
            $table->decimal("used",8,2)->change();
        });

        Schema::table('material_return_items', function (Blueprint $table) {
            $table->decimal("edited_measurement",8,2)->change();
        });
    }
};
