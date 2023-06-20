<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Shop\Product;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductUploadImageRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductsController extends Controller
{
    function index() : AnonymousResourceCollection {
        $products = QueryBuilder::for(Product::class)->jsonPaginate();
        return ProductResource::collection($products);
    }

    function show($productId) : ProductResource {
        $product = QueryBuilder::for(Product::class)
            ->allowedIncludes('brand')
            ->findOrFail($productId);
        return new ProductResource($product);
    }

    function store(ProductCreateRequest $request) : ProductResource {
        $product = QueryBuilder::for(Product::class)->create($request->validated());
        return new ProductResource($product);
    }

    function update(ProductUpdateRequest $request, $productId) : ProductResource {
        $product = QueryBuilder::for(Product::class)->findOrFail($productId);
        $product->fill($request->validated());
        if ($product->isDirty()) {
            $product->save();
        }
        return new ProductResource($product);
    }

    function uploadImage(ProductUploadImageRequest $request, $productId) : ProductResource {
        $product = QueryBuilder::for(Product::class)->findOrFail($productId);
        $path = $request->image->storeAs('products', $product->id.'.jpg');
        $product->product_image = $path;
        $product->save();
        return new ProductResource($product);
    }

    function destroy($productId) {
        $product = QueryBuilder::for(Product::class)->findOrFail($productId);
        $product->delete();

        return response(content: null, status: Response::HTTP_NO_CONTENT);
    }
}
