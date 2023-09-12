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
        Schema::create('production_yield_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yield')->default(0);
            $table->foreignId('production_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained();
            $table->date('date_added');
            $table->time('time_added');
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
        Schema::dropIfExists('production_yield_histories');
    }
};
