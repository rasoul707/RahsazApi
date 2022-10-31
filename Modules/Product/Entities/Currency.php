<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    protected $guarded = [];


    public static function updateOrCreateCurrency(Currency $currency, $request)
    {
        $currency->title_fa = $request->title_fa;
        $currency->title_en = $request->title_en;
        $currency->sign = $request->sign;
        $currency->golden_package_price = $request->golden_package_price;
        $currency->silver_package_price = $request->silver_package_price;
        $currency->bronze_package_price = $request->bronze_package_price;
        $currency->special_price = $request->special_price;
        $currency->save();
    }

    public static function updateProductsAfterCurrencyUpdated(Currency $currency)
    {
        $products = Product::query()
            ->where([
                'price_depends_on_currency' => 1,
                'currency_id' => $currency->id,
            ])->get();
        foreach ($products as $product)
        {
            $product->update([
                'price_in_toman_for_gold_group' => $product->currency_price * $currency->golden_package_price,
                'price_in_toman_for_silver_group' => $product->currency_price * $currency->silver_package_price,
                'price_in_toman_for_bronze_group' => $product->currency_price * $currency->bronze_package_price,
                'special_sale_price' => $product->currency_price * $currency->special_price,
            ]);
        }
    }

    public static function updateProductsAfterCurrencyDeleted(Currency $currency)
    {
        $products = Product::query()
            ->where([
                'price_depends_on_currency' => 1,
                'currency_id' => $currency->id,
            ])->get();
        foreach ($products as $product)
        {
            $product->update([
                'price_depends_on_currency' => 0,
                'currency_id' => null,
                'currency_price' => null,
            ]);
        }
    }
}
