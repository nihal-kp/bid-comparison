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
        Schema::create('bid_comparisons', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('currency');
            $table->string('payment_term');
            $table->string('delivery_period');
            $table->decimal('unit_cost', 10, 2);
            $table->unsignedBigInteger('vat');
            $table->decimal('awarded_line', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bid_comparisons');
    }
};
