<?php

namespace App\Http\Services;

use App\Http\DTOs\UserDTO;
use App\Http\Repositories\UserRepository;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserDTO $userDTO)
    {
        return $this->userRepository->create($userDTO);
    }

    public function login(UserDTO $userDTO)
    {
        $user = $this->userRepository->findByEmail($userDTO->getEmail());

        if ($user && password_verify($userDTO->getPassword(), $user->password)) {
            // Login successful, return token or success message
            return response()->json(['message' => 'Login successful', 'token' => 'your_token_here']);
        } else {
            // Login failed, return error message
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
}
