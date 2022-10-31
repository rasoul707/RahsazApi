<?php

namespace Modules\Form\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Form\Entities\Form;

class StoreFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['nullable'],
            'form_type' => ['required', Rule::in(Form::FORM_TYPES)],
            'request_type' => ['nullable'],
            'section_type' => ['nullable'],
            'full_name' => ['required'],
            'phone_number' => ['required', 'regex:/^09(1[0-9]|9[0-2]|2[0-2]|0[1-5]|41|3[0,3,5-9])\d{7}$/'],
            'email' => ['required', 'email'],
            'description' => ['required'],
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
