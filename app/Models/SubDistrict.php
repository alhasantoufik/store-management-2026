<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    public $timestamps = false;
    protected $table = 'sub_districts';

    protected $fillable = ['district_id', 'name', 'id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function receivers()
    {
        return $this->hasMany(Receiver::class);
    }

    // auto increment off করতে হবে (কারণ আমরা manually id insert করতেছি)
    public $incrementing = false;
    protected $keyType = 'int';
}
