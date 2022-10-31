<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\Entities\User;

class CustomerUpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            //'phone_number'=>['required', Rule::unique((new User())->getTable())->ignore(auth()->user()->id, 'id')],
            //'email'=>['required', 'email', Rule::unique((new User())->getTable())->ignore(auth()->user()->id, 'id')],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'legal_info_melli_code' => ['nullable'],
            'legal_info_economical_code' => ['nullable'],
            'legal_info_registration_number' => ['nullable'],
            'legal_info_company_name' => ['nullable'],
            'legal_info_state' => ['nullable'],
            'legal_info_city' => ['nullable'],
            'legal_info_address' => ['nullable'],
            'refund_info_bank_name' => ['nullable'],
            'refund_info_account_holder_name' => ['nullable'],
            'refund_info_cart_number' => ['nullable'],
            'refund_info_account_number' => ['nullable'],
            'refund_info_sheba_number' => ['nullable'],
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
