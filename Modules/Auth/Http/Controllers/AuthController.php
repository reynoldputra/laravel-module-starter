<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\DTO\LoginDTO;
use Modules\Auth\Http\DTO\UserDTO;
use Modules\Auth\Http\Services\AuthService;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authService;

    public function __construct(
        AuthService $authService
    ) {
        $this->authService = $authService;
    }

    public function login(LoginDTO $loginDTO)
    {
        try {
            $result = $this->authService->login($loginDTO);
            return $this->successResponse($result, "Succes log in.");
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function register(UserDTO $userDTO)
    {
        try {
            $result = $this->authService->register($userDTO);
            return $this->successResponse($result, "Success create new user.");
        } catch (Exception $e) {
            throw $e;
        }
    }
}
