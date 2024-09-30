<?php

namespace App\Http\Repositories;

use App\Http\DTOs\UserDTO;
use App\Models\User;

class UserRepository
{
    public function create(UserDTO $userDTO)
    {
        return User::create([
            'name' => $userDTO->getName(),
            'surname' => $userDTO->getsurname(),
            'email' => $userDTO->getEmail(),
            'password' => bcrypt($userDTO->getPassword()),
        ]);
    }


    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }
}
