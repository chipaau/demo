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
        $brands = QueryBuilder::for(Brand::class)->jsonPaginate();
        return BrandResource::collection($brands);
    }

    function show($brandId) : BrandResource {
        $brand = QueryBuilder::for(Brand::class)->findOrFail($brandId);
        return new BrandResource($brand);
    }

    function store(BrandCreateRequest $request) : BrandResource {
        $brand = QueryBuilder::for(Brand::class)->create($request->validated());
        return new BrandResource($brand);
    }

    function update(BrandUpdateRequest $request, $brandId) : BrandResource {
        $brand = QueryBuilder::for(Brand::class)->findOrFail($brandId);
        $brand->fill($request->validated());
        if ($brand->isDirty()) {
            $brand->save();
        }
        return new BrandResource($brand);
    }

    function destroy($brandId) {
        $brand = QueryBuilder::for(Brand::class)->findOrFail($brandId);
        $brand->delete();

        return response(content: null, status: Response::HTTP_NO_CONTENT);
    }
}
