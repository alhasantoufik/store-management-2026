<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'product_price',
        'sale_price',
        'unit',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function getCurrentStockAttribute()
    {
        $in = $this->stocks()->where('stock_type', 'in')->sum('quantity');
        $out = $this->stocks()->where('stock_type', 'out')->sum('quantity');

        return $in - $out;
    }
}
