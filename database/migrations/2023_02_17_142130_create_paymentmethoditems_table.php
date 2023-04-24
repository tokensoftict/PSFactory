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
        Schema::create('paymentmethoditems', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("customer_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("payment_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("paymentmethod_id")->nullable()->constrained()->nullOnDelete();
            $table->morphs('invoice');
            $table->date("payment_date");
            $table->decimal("amount",20,5);
            $table->text("payment_info")->nullable();
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
        Schema::dropIfExists('paymentmethoditems');
        Schema::enableForeignKeyConstraints();
    }
};
