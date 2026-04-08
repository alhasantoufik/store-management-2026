<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_in_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->unique();
            $table->string('pdf_path'); // store the file path of PDF
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_in_invoices');
    }
};