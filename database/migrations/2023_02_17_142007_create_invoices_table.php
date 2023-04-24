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
        Schema::create('invoices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("invoice_number",255)->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->enum("discount_type", ['Fixed','Percentage','None'])->nullable(); //['Fixed','Percentage','None']
            $table->decimal("discount_amount",20,5)->nullable();
            $table->decimal("discount_value",20,5)->default(0);
            $table->foreignId("status_id")->default(1)->constrained();
            $table->bigInteger("payment_id")->nullable(); // related to payment informtion
            $table->decimal("sub_total",20,5);
            $table->decimal("total_amount_paid",20,5);
            $table->decimal("total_profit",20,5);
            $table->decimal("total_cost",20,5);
            $table->decimal("total_incentives",20,5);
            $table->decimal("vat",20,5);
            $table->decimal("vat_amount",20,5);
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("last_updated_by")->nullable();
            $table->unsignedBigInteger("voided_by")->nullable();
            $table->date("invoice_date");
            $table->time("sales_time");
            $table->mediumText("void_reason")->nullable();
            $table->date("date_voided")->nullable();
            $table->time("void_time")->nullable();
            $table->timestamps();


            $table->unsignedBigInteger('picked_by')->nullable();
            $table->unsignedBigInteger('checked_by')->nullable();
            $table->unsignedBigInteger('packed_by')->nullable();
            $table->unsignedBigInteger('dispatched_by')->nullable();

            $table->foreign('picked_by')->references('id')->on('users');
            $table->foreign('checked_by')->references('id')->on('users');
            $table->foreign('packed_by')->references('id')->on('users');
            $table->foreign('dispatched_by')->references('id')->on('users');

            $table->foreign('last_updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('voided_by')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('invoices');
        Schema::enableForeignKeyConstraints();

    }
};
