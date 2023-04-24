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
        Schema::create('customerdeposits', function (Blueprint $table) {
            $table->id();
            $table->string("deposit_number",255)->index();
            $table->foreignId('payment_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal("amount",20,5)->default(0);
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("last_updated_by")->nullable();
            $table->foreignId("paymentmethoditem_id")->nullable()->constrained()->cascadeOnDelete();
            $table->date("deposit_date");
            $table->time("deposit_time");
            $table->text("description")->nullable();
            $table->foreign('last_updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('customerdeposits');
        Schema::enableForeignKeyConstraints();
    }
};
