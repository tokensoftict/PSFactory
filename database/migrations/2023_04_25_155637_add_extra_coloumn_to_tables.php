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
  /*
        Schema::table('stockbatches', function (Blueprint $table) {
            $table->decimal('cost_price')->nullable()->after('production_id');
        });

        Schema::table('rawmaterialbatches', function (Blueprint $table) {
            $table->decimal('cost_price')->nullable()->after('received_date');
        });

        Schema::table('production_material_items', function (Blueprint $table) {
            $table->decimal('cost_price')->nullable()->after('production_id');
            $table->decimal('total_cost_price')->nullable()->after('cost_price');
            $table->integer('rough')->default(0)->after('cost_price');
        });
*/
        Schema::table('productions', function (Blueprint $table) {
            $table->decimal('cost_price')->nullable()->after('stock_id');
            $table->renameColumn('quantity_1', 'starting_unscrabler');
            $table->renameColumn('quantity_2', 'starting_unibloc');
            $table->renameColumn('quantity_3', 'starting_oriental');
            $table->bigInteger('starting_labelling')->default(0)->nullable()->after('quantity_3');

            $table->bigInteger('ending_unscrabler')->default(0)->nullable()->after('starting_labelling');
            $table->bigInteger('ending_unibloc')->default(0)->nullable()->after('ending_unscrabler');
            $table->bigInteger('ending_oriental')->default(0)->nullable()->after('ending_unibloc');
            $table->bigInteger('ending_labelling')->default(0)->nullable()->after('ending_oriental');
            $table->foreignId('department_id')->nullable()->after('ending_oriental')->constrained()->nullOnDelete();
        });


        Schema::table('invoices', function(Blueprint $table){
            $table->foreignId('department_id')->nullable()->after('discount_type')->constrained()->nullOnDelete();
        });

        Schema::table('invoiceitems', function(Blueprint $table){
            $table->foreignId('department_id')->nullable()->after('invoice_id')->constrained()->nullOnDelete();
        });

        Schema::table('invoiceitembatches', function(Blueprint $table){
            $table->foreignId('department_id')->nullable()->after('invoiceitem_id')->constrained()->nullOnDelete();
        });


        Schema::table('invoice_returns', function(Blueprint $table){
            $table->foreignId('department_id')->nullable()->after('invoice_id')->constrained()->nullOnDelete();
        });

        Schema::table('invoice_returns_items', function(Blueprint $table){
            $table->foreignId('department_id')->nullable()->after('invoice_id')->constrained()->nullOnDelete();
        });



        Schema::table('departments', function(Blueprint $table){
            $table->enum('department_type',['Store','Sales'])->default('Store')->after('name');
            $table->string('quantity_column',50)->nullable()->index()->after('name');
        });





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('production_material_items', function (Blueprint $table) {
            $table->dropColumn('cost_price');
            $table->dropColumn('total_cost_price');
            $table->dropColumn('rough');
        });

        Schema::table('stockbatches', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });

        Schema::table('rawmaterialbatches', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('cost_price');
            $table->renameColumn('starting_unscrabler', 'quantity_1');
            $table->renameColumn('starting_unibloc', 'quantity_2');
            $table->renameColumn('starting_oriental', 'quantity_3');
            $table->dropColumn('starting_labelling');

            $table->dropColumn('ending_unscrabler');
            $table->dropColumn('ending_unibloc');
            $table->dropColumn('ending_oriental');
            $table->dropColumn('ending_labelling');
        });


        Schema::table('invoices', function(Blueprint $table){
            $table->dropConstrainedForeignId('department_id');
        });


        Schema::table('invoiceitems', function(Blueprint $table){
            $table->dropConstrainedForeignId('department_id');
        });

        Schema::table('invoiceitembatches', function(Blueprint $table){
            $table->dropConstrainedForeignId('department_id');
        });


        Schema::table('invoice_returns', function(Blueprint $table){
            $table->dropConstrainedForeignId('department_id');
        });

        Schema::table('invoice_returns_items', function(Blueprint $table){
            $table->dropConstrainedForeignId('department_id');
        });


        Schema::table('departments', function(Blueprint $table){
            $table->dropColumn('department_type');
            $table->dropColumn('quantity_column');
        });

    }
};
