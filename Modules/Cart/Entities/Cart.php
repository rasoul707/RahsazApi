<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderProduct;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;

class Cart extends Model
{
    protected $table = 'carts';
    protected $guarded = [];
    protected $appends = ['total_price'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartProduct::class);
    }


    public function getTotalPriceAttribute()
    {
        return $this->totalPrice();
    }

    public function totalPrice()
    {
       $items = $this->items()->get();
       $totalPrice = 0;
       foreach ($items as $item)
       {
           $totalPrice += $item->totalPrice();
       }

       return $totalPrice;
    }


    public static function addProduct(Cart $cart, Product $product, $count)
    {
        $cartProduct = CartProduct::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        $user = User::query()->findOrFail($cart->user->id);

        if(!$cartProduct)
        {
            $rate = $product->calculatePurchasePrice();
            if($rate == 0 || empty($rate))
            {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'error' => ['امکان اضافه کردن این محصول به سبد خرید ممکن نمیباشد.'],
                ]);
                throw $error;
            }
            CartProduct::query()
                ->create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'count' => $count,
                    'rate' => $rate
                ]);
        }
        else{
            $rate = $product->calculatePurchasePrice();
            if($rate == 0 || empty($rate))
            {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'error' => ['امکان اضافه کردن این محصول به سبد خرید ممکن نمیباشد.'],
                ]);
                throw $error;
            }
            $cartProduct->count = $cartProduct->count + $count;
            $cartProduct->rate = $rate;
            $cartProduct->save();

        }
    }

    public static function deleteProduct(Cart $cart, Product $product)
    {
        $cartProduct = CartProduct::query()
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if($cartProduct)
        {
            $cartProduct->delete();
        }
    }


    public static function emptyCart(Cart $cart)
    {
        CartProduct::query()
            ->where('cart_id', $cart->id)
            ->delete();
    }


    public function finalize()
    {
        if($this->items()->count() == 0)
        {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'error' => ['سبد خرید خالی است.'],
            ]);
            throw $error;
        }

        $order = Order::query()
            ->create([
                'user_id' => $this->user_id,
                'process_status' => Order::PROCESS_STATUSES['در انتظار تایید سفارش'],
                'overall_status' => Order::OVERALL_STATUSES['پرداخت نشده'],
            ]);

        $cartProducts = CartProduct::query()
            ->where('cart_id', $this->id)
            ->get();

        foreach ($cartProducts as $cartProduct)
        {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cartProduct->product_id;
            $orderProduct->count = $cartProduct->count;
            $orderProduct->rate = $cartProduct->rate;
            $orderProduct->status = OrderProduct::STATUSES['در انتظار تایید'];
            $orderProduct->save();
        }

        self::emptyCart($this);
        return $order;
    }
}
