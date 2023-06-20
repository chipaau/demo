<?php

namespace App\Http\Controllers;

use App\Models\Shop\Product;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductsController extends Controller
{
    function index() : AnonymousResourceCollection {
        $customers = QueryBuilder::for(Product::class)->jsonPaginate();
        return ProductResource::collection($customers);
    }

    function show($customerId) : ProductResource {
        $customer = QueryBuilder::for(Product::class)
            ->allowedIncludes('brand')
            ->findOrFail($customerId);
        return new ProductResource($customer);
    }

    function store(ProductCreateRequest $request) : ProductResource {
        $customer = QueryBuilder::for(Product::class)->create($request->validated());
        return new ProductResource($customer);
    }

    function update(ProductUpdateRequest $request, $customerId) : ProductResource {
        $customer = QueryBuilder::for(Product::class)->findOrFail($customerId);
        $customer->fill($request->validated());
        if ($customer->isDirty()) {
            $customer->save();
        }
        return new ProductResource($customer);
    }

    function destroy($customerId) {
        $customer = QueryBuilder::for(Product::class)->findOrFail($customerId);
        $customer->delete();

        return response(content: null, status: Response::HTTP_NO_CONTENT);
    }
}
