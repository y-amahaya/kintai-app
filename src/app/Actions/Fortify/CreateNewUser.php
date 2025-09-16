<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'name'          => ['required', 'string', 'max:50'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Password::defaults()],
        ])->validate();

        return User::create([
            'name'          => $input['name'],
            'email'         => $input['email'],
            'password'      => Hash::make($input['password']),
            'role'          => User::ROLE_EMPLOYEE,
        ]);
    }
}
