<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_no',
        'pdf_path',
    ];
}