<?php

namespace App\Http\Controllers;

use App\Models\Shop\Customer;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CustomersController extends Controller
{
    function index() : AnonymousResourceCollection {
        $customers = QueryBuilder::for(Customer::class)
            ->allowedFilters(['name', 'email'])
            ->jsonPaginate();
        return CustomerResource::collection($customers);
    }

    function show($customerId) : CustomerResource {
        $customer = QueryBuilder::for(Customer::class)->findOrFail($customerId);
        return new CustomerResource($customer);
    }

    function store(CustomerCreateRequest $request) : CustomerResource {
        $customer = QueryBuilder::for(Customer::class)->create($request->validated());
        return new CustomerResource($customer);
    }

    function update(CustomerUpdateRequest $request, $customerId) : CustomerResource {
        $customer = QueryBuilder::for(Customer::class)->findOrFail($customerId);
        $customer->fill($request->validated());
        if ($customer->isDirty()) {
            $customer->save();
        }
        return new CustomerResource($customer);
    }

    function destroy($customerId) {
        $customer = QueryBuilder::for(Customer::class)->findOrFail($customerId);
        $customer->delete();

        return response(content: null, status: Response::HTTP_NO_CONTENT);
    }
}
