<?php

namespace Modules\WebsiteSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxAndRoundingStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'taxation_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'charges_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'is_rounding_enable' => ['required', 'boolean'],
            'rounding_price' => ['required', 'numeric'],
            'rounding_target' => ['required', 'numeric'],
            'rounding_flag' => ['required', 'in:up,down'],
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
