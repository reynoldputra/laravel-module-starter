<?php

namespace Modules\Auth\Http\Services;

use Exception;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\DTO\UserDTO;
use Modules\Auth\Http\DTO\LoginDTO;
use Illuminate\Support\Facades\Auth;

class AuthService {
    public function register(UserDTO $userDTO)
    {
        $input = $userDTO->getInputData();
        $createdUser = User::create($input);
        return [
            'name' => $createdUser->name,
            'email' => $createdUser->email
        ];
    } 

    public function login(LoginDTO $loginDTO)
    {
        $input = $loginDTO->getInputData();
        if(!Auth::attempt($input)) {
            throw new Exception("Invalid email or password", 401);
        }
        $user = Auth::user();
        $tokenResult = $user->createToken('my-api');
        $accessToken = $tokenResult->accessToken;
        return [
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $tokenResult->token->expires_at->toDateTimeString()
        ]; 
    }
}