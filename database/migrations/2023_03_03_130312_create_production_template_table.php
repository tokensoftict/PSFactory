<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('production_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete();
            $table->string("name");
            $table->date('date_created');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean("status");
            $table->bigInteger('expected_quantity')->default(0);
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->foreign('last_updated_by')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('production_templates');
        Schema::enableForeignKeyConstraints();
    }
};
