<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:shop_customers,email',
            'photo' => 'image',
            'gender' => 'required|in:male,female',
            'phone' => 'required',
            'birthday' => 'required|date|date_format:Y-m-d',
        ];
    }
}
