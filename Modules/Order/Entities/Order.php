<?php

namespace Modules\Order\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Modules\Coupon\Entities\Coupon;
use Modules\Library\Entities\Image;
use Modules\User\Entities\Address;
use Modules\User\Entities\User;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = [];
    protected $appends = ['total_amount_without_delivery_amount'];

    const OVERALL_STATUSES = [
        "پرداخت نشده" => "پرداخت نشده",
        "در حال پردازش" => "در حال پردازش",
        "تکمیل شده" => "تکمیل شده",
        "حذف شده" => "حذف شده",
    ];


    const PROCESS_STATUSES = [
        "در انتظار تایید سفارش" => "در انتظار تایید سفارش",
        "در حال بسته بندی" => "در حال بسته بندی",
        "خروج از انبار" => "خروج از انبار",
        "تحویل به باربری" => "تحویل به باربری",
        "تکمیل شده" => "تکمیل شده",
        "کنسل شده" => "کنسل شده",
        "مرجوع شده" => "مرجوع شده",
    ];


    const PAYMENT_TYPES = [
        'فیش بانکی' => 'فیش بانکی',
        'درگاه آنلاین' => 'درگاه آنلاین',
    ];



    const DELIVERY_TYPES = [
        'تحویل درب انبار شرکت' => 'تحویل درب انبار شرکت',
        'باربری - پس کرایه' => 'باربری - پس کرایه',
        'اتوبوس - پس کرایه' => 'اتوبوس - پس کرایه',
    ];





    /* Relations */
    public function user()
    {
        return $this->belongsTo(User::class)->select([
            'id',
            'first_name',
            'last_name',
            'phone_number',
            'email'
        ]);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class)->with(['product']);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function bijakImage()
    {
        return $this->belongsTo(Image::class, 'bijak_image_id','id');
    }

    public function bankReceiptImage()
    {
        return $this->belongsTo(Image::class, 'bank_receipt_image_id','id');
    }

    /* Mutators */

    public function getNumberOfProductsAttribute()
    {
        return $this->products()->count();
    }

    public function getTotalAmountAttribute()
    {
        return $this->totalAmount();
    }


    public function getTotalAmountWithoutTaxAttribute()
    {
        return $this->totalAmountWithoutTax();
    }

    public function getTotalAmountWithoutDeliveryAmountAttribute()
    {
        return $this->totalAmountWithoutDeliveryAmount();
    }

    /* Methods */
    public function totalAmountWithoutDeliveryAmount()
    {
        $products = $this->products()->get();
        $totalAmount = 0;
        foreach ($products as $product)
        {
            $totalAmount += $product->totalAmount();
        }

        if(!empty($this->coupon_id))
        {
            $coupon = Coupon::query()
                ->where('id', $this->coupon_id)
                ->first();

            if($coupon)
            {
                if($coupon->type == Coupon::TYPES['ثابت روی سبد خرید'])
                    $totalAmount -= $coupon->amount;
                elseif($coupon->type == Coupon::TYPES['درصد روی سبد خرید'])
                    $totalAmount = ((100 - $coupon->amount)/100) * $totalAmount;
            }
        }

        return round($totalAmount,2) + round(9/100 * $totalAmount ,2);
    }

    public function totalAmount()
    {
        $products = $this->products()->get();
        $totalAmount = 0;
        foreach ($products as $product)
        {
            $totalAmount += $product->totalAmount();
        }
        if($this->delivery_amount)
            $totalAmount += $this->delivery_amount;

        // TODO : apply coupon
        if(!empty($this->coupon_id))
        {
            $coupon = Coupon::query()
                ->where('id', $this->coupon_id)
                ->first();

            if($coupon)
            {
                if($coupon->type == Coupon::TYPES['ثابت روی سبد خرید'])
                    $totalAmount -= $coupon->amount;
                elseif($coupon->type == Coupon::TYPES['درصد روی سبد خرید'])
                    $totalAmount = ((100 - $coupon->amount)/100) * $totalAmount;
            }
        }

        return round($totalAmount,2) + round(9/100 * $totalAmount ,2);
    }

    public function totalAmountWithoutTax()
    {
        $products = $this->products()->get();
        $totalAmount = 0;
        foreach ($products as $product)
        {
            $totalAmount += $product->totalAmount();
        }
        if($this->delivery_amount)
            $totalAmount += $this->delivery_amount;

        // TODO : apply coupon
        if(!empty($this->coupon_id))
        {
            $coupon = Coupon::query()
                ->where('id', $this->coupon_id)
                ->first();

            if($coupon)
            {
                if($coupon->type == Coupon::TYPES['ثابت روی سبد خرید'])
                    $totalAmount -= $coupon->amount;
                elseif($coupon->type == Coupon::TYPES['درصد روی سبد خرید'])
                    $totalAmount = ((100 - $coupon->amount)/100) * $totalAmount;
            }
        }

        return round($totalAmount,2);
    }

    public function mostSaleCityOfMonth($date)
    {
        return DB::table('addresses')
            ->whereBetween('created_at', [
                Carbon::parse($date)->startOfMonth(),
                Carbon::parse($date)->endOfMonth(),
            ])
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderByDesc('total')
            ->first();
    }
}
