<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\Entities\User;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['required', 'in:'. implode(',',array_keys(User::STATUSES))],
            'package' => ['required', 'in:'. implode(',',array_keys(User::PACKAGES))],
            'role' => ['required', 'in:'. implode(',',array_keys(User::ROLES))],
            'first_name' => ['nullable'],
            'last_name' => ['nullable'],
            'username' => ['nullable'],
            'phone_number' => ['required', 'regex:'. User::IRAN_PHONE_NUMBER_REGEX, Rule::unique('users')->ignore($this->route('id'))],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($this->route('id'))],
            'state' => ['nullable'],
            'city' => ['nullable'],
            'address' => ['nullable'],
            'birthday' => ['nullable'],
            'legal_info_melli_code' => ['nullable'],
            'legal_info_economical_code' => ['nullable'],
            'legal_info_registration_number' => ['nullable'],
            'legal_info_company_name' => ['nullable'],
            'legal_info_state' => ['nullable'],
            'legal_info_city' => ['nullable'],
            'legal_info_address' => ['nullable'],
            'legal_info_phone_number' => ['nullable'],
            'legal_info_postal_code' => ['nullable'],
            'refund_info_bank_name' => ['nullable'],
            'refund_info_account_holder_name' => ['nullable'],
            'refund_info_cart_number' => ['nullable'],
            'refund_info_account_number' => ['nullable'],
            'refund_info_sheba_number' => ['nullable'],
            'password' => ['nullable'],
            'guild_identifier' => ['nullable'],
            'store_name' => ['nullable'],
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
