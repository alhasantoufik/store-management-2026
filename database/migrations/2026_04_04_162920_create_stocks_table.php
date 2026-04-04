<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();

            // Foreign key with index (better performance)
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // Use unsignedInteger (stock কখনো negative হবে না)
            $table->unsignedInteger('quantity');

            // Stock type (in / out)
            $table->enum('stock_type', ['in', 'out'])
                  ->default('in')
                  ->index(); // filter fast হবে

            // Optional note
            $table->text('note')->nullable();

            // Add index for faster query (important for stock calculation)
            $table->index(['product_id', 'stock_type']);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stocks');
    }
};