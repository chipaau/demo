<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'shop_brand_id' => 'exists:shop_brands,id',
            'slug' => ['sometimes', Rule::unique('shop_products', 'slug')->ignore($this->route('id'))],
            'sku' => ['sometimes', Rule::unique('shop_products', 'sku')->ignore($this->route('id'))],
            'barcode' => ['sometimes', Rule::unique('shop_products', 'barcode')->ignore($this->route('id'))],
            'description' => 'sometimes',
            'qty' => 'required|numeric',
            'security_stock' => 'required|numeric',
            'featured' => 'required|boolean',
            'is_visible' => 'required|boolean',
            'seo_title' => 'sometimes',
            'seo_description' => 'sometimes',
            'sort' => 'sometimes|numeric',
            'old_price' => 'sometimes|numeric',
            'price' => 'sometimes|numeric',
            'cost' => 'sometimes|numeric',
            'type' => 'sometimes|in:deliverable,downloadable',
            'published_at' => 'sometimes|date',
            'weight_value' => 'sometimes|numeric',
            'weight_unit' => 'sometimes',
            'height_value' => 'sometimes|numeric',
            'height_unit' => 'sometimes',
            'width_value' => 'sometimes|numeric',
            'width_unit' => 'sometimes',
            'depth_value' => 'sometimes|numeric',
            'depth_unit' => 'sometimes',
            'volume_value' => 'sometimes|numeric',
            'volume_unit' => 'sometimes',
        ];
    }
}
