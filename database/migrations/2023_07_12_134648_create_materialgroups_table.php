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
        Schema::create('materialgroups', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::table('rawmaterials', function (Blueprint $table) {
            $table->foreignId("materialgroup_id")->after('department_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rawmaterials', function (Blueprint $table) {
            $table->dropConstrainedForeignId("materialgroup_id");
        });

        Schema::dropIfExists('materialgroups');
    }
};
