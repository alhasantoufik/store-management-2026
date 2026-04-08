<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $fillable = [
        'cost_category_id',
        'cost_field_id', // ✅ new
        'amount',
        'cost_by',
        'date'
    ];

    public function category()
    {
        return $this->belongsTo(CostCategory::class, 'cost_category_id');
    }

    public function field()
    {
        return $this->belongsTo(CostField::class, 'cost_field_id');
    }
}
