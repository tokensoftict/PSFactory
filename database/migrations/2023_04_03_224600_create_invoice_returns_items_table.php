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
        Schema::create('invoice_returns_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId("invoice_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("invoice_return_id")->constrained()->cascadeOnDelete();
            $table->foreignId("customer_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("status_id")->constrained()->cascadeOnDelete();
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete();
            $table->bigInteger("quantity");
            $table->bigInteger("pieces");
            $table->unsignedBigInteger("added_by");
            $table->decimal("cost_price",20,5)->nullable();
            $table->decimal("selling_price",20,5)->nullable();
            $table->decimal("total_cost_price",20,5)->nullable();
            $table->decimal("total_selling_price",20,5)->nullable();
            $table->decimal("total_profit",20,5)->nullable();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('invoice_returns_items');
        Schema::enableForeignKeyConstraints();
    }
};
