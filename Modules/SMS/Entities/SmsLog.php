<?php

namespace Modules\SMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsLog extends Model
{
    protected $table = 'sms_logs';
    protected $guarded = [];
}
