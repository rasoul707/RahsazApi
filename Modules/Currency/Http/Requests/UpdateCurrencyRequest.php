<?php

namespace Modules\Currency\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCurrencyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_fa' => ['required'],
            'title_en' => ['required', Rule::unique('currencies')->ignore($this->title_en, 'title_en')],
            'sign' => ['required'],
            'golden_package_price' => ['required'],
            'silver_package_price' => ['required'],
            'bronze_package_price' => ['required'],
            'special_price' => ['required'],
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
