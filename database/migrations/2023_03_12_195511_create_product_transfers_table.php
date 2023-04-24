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
        Schema::create('product_transfers', function (Blueprint $table) {
            $table->id();
            $table->date('transfer_date')->nullable();
            $table->time('transfer_time')->nullable();
            $table->decimal("quantity")->default(0);
            $table->decimal("pieces")->default(0);
            $table->decimal("approved_quantity")->default(0);
            $table->decimal("approved_pieces")->default(0);
            $table->nullableMorphs("transferable");
            $table->unsignedBigInteger('transfer_by_id')->nullable();
            $table->unsignedBigInteger('resolve_by_id')->nullable();
            $table->foreignId("status_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("stock_id")->constrained()->cascadeOnDelete();
            $table->date('resolve_date')->nullable();
            $table->time('resolve_time')->nullable();
            $table->foreign('transfer_by_id')->on('users')->references('id')->nullOnDelete();
            $table->foreign('resolve_by_id')->on('users')->references('id')->nullOnDelete();
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
        Schema::dropIfExists('product_transfers');
        Schema::enableForeignKeyConstraints();
    }
};
