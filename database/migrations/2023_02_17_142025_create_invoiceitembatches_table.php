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
        Schema::create('invoiceitembatches', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoiceitem_id')->constrained()->cascadeOnDelete();
            $table->foreignId('stock_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('stockbatch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId("customer_id")->nullable()->constrained()->nullOnDelete();
            $table->string("batchno")->nullable();
            $table->decimal("cost_price",20,5);
            $table->decimal("selling_price",20,5);
            $table->decimal("profit",20,5);
            $table->decimal("incentives",20,5);
            $table->integer('quantity');
            $table->date("invoice_date");
            $table->time("sales_time");
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
        Schema::dropIfExists('invoiceitembatches');
        Schema::enableForeignKeyConstraints();
    }
};
