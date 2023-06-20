<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandCreateRequest extends FormRequest
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
            'slug' => 'required|unique:shop_brands,slug',
            'website' => 'sometimes',
            'description' => 'sometimes',
            'position' => 'required|numeric',
            'is_visible' => 'required|boolean',
            'seo_title' => 'sometimes',
            'seo_description' => 'sometimes',
            'sort' => 'sometimes|numeric',
        ];
    }
}
