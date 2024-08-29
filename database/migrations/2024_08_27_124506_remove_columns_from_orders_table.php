<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_details');
            $table->renameColumn('total_quantity_of_items', 'total_qty_of_all_items_ordered');
            $table->renameColumn('no_of_items_ordered', 'no_of_all_items_ordered');
            $table->renameColumn('total_amount_in_naira', 'total_amt_of_all_order_items_in_naira');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
