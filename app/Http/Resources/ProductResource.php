<?php

namespace App\Http\Resources;

use App\Http\Resources\BrandResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => Storage::url($this->product_image),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'slug' => $this->slug,
            'sku' => $this->sku,
            'barcode' => $this->barcode,
            'description' => $this->description,
            'qty' => $this->qty,
            'security_stock' => $this->security_stock,
            'featured' => $this->featured,
            'is_visible' => $this->is_visible,
            'old_price' => (float) $this->old_price,
            'price' => (float) $this->price,
            'cost' => (float) $this->cost,
            'type' => $this->type,
            'published_at' => $this->published_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->toIso8601ZuluString('microsecond'),
            'updated_at' => $this->updated_at->toIso8601ZuluString('microsecond'),
        ];
    }
}
