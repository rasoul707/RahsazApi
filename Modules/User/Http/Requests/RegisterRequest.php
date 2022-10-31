<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Entities\User;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => ['required', 'in:'. implode(',', array_keys(User::ROLES))],
            'phone_number' => ['required', 'unique:users,phone_number'],
            'password' => ['required'],
        ];
    }

    public function requiredIf($key)
    {
        if($this->role == User::ROLES['مشتری'])
        {
            if(in_array($key,[
                'first_name',
                'last_name',
                'legal_info_melli_code',
                'phone_number',
                'state',
                'city',
                'address',
                'password',
            ]))
                return 'required';

        }

        if($this->role == User::ROLES['همکار'])
        {
            if(in_array($key,[
                'first_name',
                'last_name',
                'legal_info_melli_code',
                'phone_number',
                'state',
                'city',
                'address',
                'password',
                'guild_identifier',
                'store_name',
            ]))
                return 'required';

        }

        if($this->role == User::ROLES['شرکت'])
        {
            if(in_array($key,[
                'type',
                'role',
                'legal_info_company_name',
                'phone_number',
                'state',
                'city',
                'address',
                'password',
                'legal_info_melli_code',
                'legal_info_economical_code',
                'legal_info_registration_number',
                'legal_info_state',
                'legal_info_city',
                'legal_info_address',
                'legal_info_postal_code',
                'legal_info_phone_number',
            ]))
                return 'required';

        }
        return 'nullable';
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
