<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostField extends Model
{
    protected $fillable = ['cost_category_id', 'name'];

    public function category()
    {
        return $this->belongsTo(CostCategory::class, 'cost_category_id');
    }
    public function costs()
    {
        return $this->hasMany(Cost::class);
    }
}
