<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    function authUser(Request $request) : UserResource {
        return new UserResource($request->user());
    }
}
