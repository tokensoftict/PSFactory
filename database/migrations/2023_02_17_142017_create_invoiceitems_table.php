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
        Schema::create('invoiceitems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId("invoice_id")->constrained()->cascadeOnDelete();
            $table->foreignId("stock_id")->nullable()->constrained()->nullOnDelete();
            $table->bigInteger("quantity");
            $table->foreignId("customer_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("status_id")->constrained()->cascadeOnDelete(); //["PAID","DRAFT","DISCOUNT","VOID","HOLD","COMPLETE"]
            $table->unsignedBigInteger("added_by");
            $table->date("invoice_date");
            $table->time("sales_time");
            $table->decimal("cost_price",20,5)->nullable();
            $table->decimal("selling_price",20,5)->nullable();
            $table->decimal("profit",20,5)->nullable();
            $table->decimal("total_cost_price",20,5)->nullable();
            $table->decimal("total_selling_price",20,5)->nullable();
            $table->decimal("total_profit",20,5)->nullable();
            $table->decimal("total_incentives",20,5)->nullable();
            $table->enum("discount_type", ['Fixed','Percentage','None'])->nullable(); //['Fixed','Percentage','None']
            $table->decimal("discount_amount",20,5)->nullable();
            $table->unsignedBigInteger('discount_added_by')->nullable();
            $table->decimal("discount_value",20,5)->default(0);
            $table->timestamps();

            $table->foreign('discount_added_by')->references('id')->on('users');
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
        Schema::dropIfExists('invoiceitems');
        Schema::enableForeignKeyConstraints();
    }
};
