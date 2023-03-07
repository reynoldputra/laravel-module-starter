<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\DTO\UserDTO;
use Modules\Auth\Http\Requests\LoginDTO;
// use Modules\Auth\Http\DTO\LoginDTO;
// use Modules\Auth\Http\Requests\LoginDTO;

class AuthController extends Controller
{
    public function login(LoginDTO $request){
        dd($request);
    }

    public function register(Request $request){
        dd($request);
    }
}
