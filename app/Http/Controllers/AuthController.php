<?php

namespace App\Http\Controllers;

use App\Http\DTOs\UserDTO;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $userDTO = new UserDTO(
            $request->name,
            $request->surname,
            $request->email,
            $request->password
        );

        return $this->authService->register($userDTO);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $userDTO = new UserDTO(null,null, $request->email, $request->password);
        return $this->authService->login($userDTO);
    }


}
