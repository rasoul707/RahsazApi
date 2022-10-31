<?php

namespace Modules\Coupon\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Couponable extends Model
{
    protected $table = 'couponables';
    protected $guarded = [];

    const STATUS = [
        'allowed' => 'allowed',
        'forbidden' => 'forbidden',
    ];
}
