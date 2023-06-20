<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandUpdateRequest extends FormRequest
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
            'slug' => ['sometimes', Rule::unique('shop_brands', 'slug')->ignore($this->route('id'))],
            'website' => 'sometimes',
            'description' => 'sometimes',
            'position' => 'sometimes|numeric',
            'is_visible' => 'sometimes|boolean',
            'seo_title' => 'sometimes',
            'seo_description' => 'sometimes',
            'sort' => 'sometimes|numeric',
        ];
    }
}
