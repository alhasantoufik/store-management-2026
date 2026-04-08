<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{

    const TYPE_IN = 'in';
    const TYPE_OUT = 'out';
    const TYPE_RETURN = 'return';

    protected $casts = [
        'in_date' => 'datetime', // ensures $t->in_date is Carbon instance
    ];

    protected $fillable = [
        'product_id',
        'type',
        'previous_stock',
        'quantity',
        'current_stock',
        'note',
        'total_price', // ✅ MUST
        'in_date', // ✅ MUST
        'voucher_no', // ✅ OPTIONAL
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
