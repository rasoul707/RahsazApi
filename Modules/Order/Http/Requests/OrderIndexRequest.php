<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Order\Entities\Order;

class OrderIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'offset' => ['required', 'numeric', 'min:0'],
            'overall_status' => ['nullable', 'in:'.implode(',', array_keys(Order::OVERALL_STATUSES))],
            'process_status' => ['nullable', 'in:'.implode(',', array_keys(Order::OVERALL_STATUSES))],
            'custom_sort' => ['nullable'],
            'search' => ['nullable'],
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
