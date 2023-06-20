<?php

namespace App\Http\Controllers;

use App\Models\Shop\Brand;
use Illuminate\Http\Response;
use App\Http\Resources\BrandResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\BrandCreateRequest;
use App\Http\Requests\BrandUpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BrandsController extends Controller
{
    function index() : AnonymousResourceCollection {
        $customers = QueryBuilder::for(Brand::class)->jsonPaginate();
        return BrandResource::collection($customers);
    }

    function show($customerId) : BrandResource {
        $customer = QueryBuilder::for(Brand::class)->findOrFail($customerId);
        return new BrandResource($customer);
    }

    function store(BrandCreateRequest $request) : BrandResource {
        $customer = QueryBuilder::for(Brand::class)->create($request->validated());
        return new BrandResource($customer);
    }

    function update(BrandUpdateRequest $request, $customerId) : BrandResource {
        $customer = QueryBuilder::for(Brand::class)->findOrFail($customerId);
        $customer->fill($request->validated());
        if ($customer->isDirty()) {
            $customer->save();
        }
        return new BrandResource($customer);
    }

    function destroy($customerId) {
        $customer = QueryBuilder::for(Brand::class)->findOrFail($customerId);
        $customer->delete();

        return response(content: null, status: Response::HTTP_NO_CONTENT);
    }
}
