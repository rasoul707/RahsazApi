<?php

namespace App\Http\Controllers;


use App\Mail\FormSubmitted;
use App\Notifications\FarazSMSNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Modules\Cart\Entities\Cart;
use Modules\MegaMenu\Entities\MegaMenu;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test()
    {
        MegaMenu::make();
    }


    public function testAddToCart()
    {
        //return Cart::query()->with(['products'])->inRandomOrder()->first();
        $cart = User::firstOrCreateCart(User::query()->where('id', 36)->first());
        $product = Product::query()->inRandomOrder()->first();
        $count = rand(1,10);
        Cart::addProduct($cart, $product, $count);
    }
}
