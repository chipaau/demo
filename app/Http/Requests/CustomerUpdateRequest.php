<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes',
            'email' => ['sometimes', Rule::unique('shop_customers', 'email')->ignore($this->route('id'))],
            'photo' => 'sometimes|image',
            'gender' => 'sometimes|in:male,female',
            'phone' => 'sometimes',
            'birthday' => 'sometimes|date|date_format:Y-m-d',
        ];
    }
}
