<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'previous_sms',
        'amount',
        'sms',
    ];
}
