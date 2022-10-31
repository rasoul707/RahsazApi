<?php

namespace Modules\Coupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Coupon\Entities\Coupon;

class StoreCouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => ['required', 'unique:coupons,code'],
            'description' => ['nullable'],
            'type' => ['required', 'in:'.implode(',', array_keys(Coupon::TYPES))],
            'amount_type' => ['required', 'in:'.implode(',', array_keys(Coupon::AMOUNT_TYPE))],
            'amount' => ['required', 'numeric'],
            'expired_at' => ['nullable'],
            'limit_count' => ['nullable'],
            'min_amount' => ['nullable'],
            'max_amount' => ['nullable'],

            'allowed_product_ids' => ['array', 'nullable'],
            'allowed_category_ids' => ['array', 'nullable'],
            'allowed_user_ids' => ['array', 'nullable'],
            'allowed_packages' => ['array', 'nullable'],
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
