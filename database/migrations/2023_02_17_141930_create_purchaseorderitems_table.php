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
        Schema::create('purchaseorderitems', function (Blueprint $table) {
            $table->id();
            $table->engine = 'InnoDB';
            $table->foreignId("purchaseorder_id")->constrained()->cascadeOnDelete();
            $table->nullableMorphs("purchase");
            $table->nullableMorphs("batch");
            $table->date("expiry_date")->nullable();
            $table->foreignId("department_id")->constrained()->cascadeOnDelete();
            $table->decimal("measurement")->default("0");

            $table->decimal("cost_price",20,5)->nullable();
            $table->decimal("selling_price",20,5)->nullable();
            $table->unsignedBigInteger("added_by")->nullable();
            $table->timestamps();
            $table->foreign('added_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('purchaseorderitems');
        Schema::enableForeignKeyConstraints();

    }
};
