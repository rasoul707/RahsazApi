<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'note_before_buy' => ['nullable'],
            'description' => ['nullable'],
            'price_in_toman_for_gold_group' => ['nullable', 'numeric'],
            'price_in_toman_for_silver_group' => ['nullable', 'numeric'],
            'price_in_toman_for_bronze_group' => ['nullable', 'numeric'],
            'special_sale_price' => ['nullable', 'numeric'],
            'special_price_started_at' => ['required_with:special_sale_price'],
            'special_price_expired_at' => ['required_with:special_price_started_at'],
            'currency_id' => ['nullable', 'exists:currencies,id'],
            'currency_price' => ['required_with:currency_id', 'numeric'],
            'price_depends_on_currency' => ['required_with:currency_id'],
            'weight' => ['nullable'],
            'length' => ['nullable'],
            'width' => ['nullable'],
            'height' => ['nullable'],
            'management_enable' => ['nullable'],
            'supply_count_in_store' => ['nullable', 'numeric'],
            'low_supply_alert' => ['nullable', 'numeric'],
            'only_sell_individually' => ['nullable'],
            'shelf_code' => ['nullable'],
            'supplier_price' => ['nullable', 'numeric'],
            'manufacturing_country' => ['nullable', 'string'],

            // relations
            'other_names' => ['nullable', 'array'], // relation
            'tags' => ['nullable', 'array'], // relation
            'cover_image_id' => ['nullable'], // relation
            'gallery_image_ids' => ['nullable'], // relation
            'video_ids' => ['nullable'], // relation
            'similar_product_ids' => ['nullable'],// relation
            'product_attributes' => ['nullable'], // relation
            'sub_category_ids' => ['nullable'], // relation
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
