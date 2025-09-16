<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail(),
            'password'          => 'password',
            'role'              => User::ROLE_EMPLOYEE,
            'email_verified_at' => now(),
        ];
    }

    /** 管理者ロール */
    public function admin(): self
    {
        return $this->state(fn () => ['role' => User::ROLE_ADMIN]);
    }

    /** 一般ロール */
    public function employee(): self
    {
        return $this->state(fn () => ['role' => User::ROLE_EMPLOYEE]);
    }
}
