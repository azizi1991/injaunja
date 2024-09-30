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
            session(['user' => $user]);
            return response()->json(['success' => true, 'message' => 'Login successful']);
        } else {

            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }
    }


}
