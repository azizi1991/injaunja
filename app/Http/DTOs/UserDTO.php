<?php
namespace App\Http\DTOs;

class UserDTO
{
    public $name;
    public $surname;
    public $email;
    public $password;

    public function __construct($name, $surname, $email, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName() { return $this->name; }
    public function getsurname() { return $this->surname; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
}
