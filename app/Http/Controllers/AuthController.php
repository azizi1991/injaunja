<?php

namespace App\Http\Controllers;

use App\Http\DTOs\UserDTO;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // متد ثبت‌نام
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $userDTO = new UserDTO(
            $request->name,
            $request->email,
            $request->password
        );

        return $this->authService->register($userDTO);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ساختن DTO برای کاربر
        $userDTO = new UserDTO(
            null, // نام را نمی‌فرستید چون در لاگین نیازی به آن نیست
            $request->email,
            $request->password
        );

        return $this->authService->login($userDTO);
    }

}
