<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class OrderProduct extends Model
{
    protected $table = 'order_products';
    protected $guarded = [];
    protected $appends = ['total_amount', 'tax_amount', 'total_amount_with_tax','charge_amount'];

    const STATUSES = [
        'در انتظار تایید' => 'در انتظار تایید',
        'تایید شده' => 'تایید شده',
        'مرجوعی' => 'مرجوعی',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }


    public function getTotalAmountAttribute()
    {
        return $this->totalAmount();
    }

    public function totalAmount()
    {
        if ($this->status == self::STATUSES['مرجوعی']) {
            return 0;
        }

        return $this->count * $this->rate;
    }


    public function getTaxAmountAttribute()
    {
        return $this->taxAmount();
    }

    public function taxAmount()
    {
        return round($this->totalAmount() * (6 / 100), 2) ;
    }

    public function getChargeAmountAttribute()
    {
        return $this->chargeAmount();
    }

    public function chargeAmount()
    {
        return round($this->totalAmount() * (3 / 100), 2) ;
    }


    
    


    public function getTotalAmountWithTaxAttribute()
    {
        return $this->totalAmountWithTax();
    }

    public function totalAmountWithTax()
    {
        return $this->totalAmount() + $this->taxAmount();
    }
}
