<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
     protected $fillable = [
        'mobile',
        'message',
        'status',
        'sms_count',
    ];
}
