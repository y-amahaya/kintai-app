<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;
use App\Actions\Fortify\CreateNewUser;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }

    public function boot(): void
    {
        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn () => view('auth.register'));

        Fortify::authenticateUsing(function (Request $request) {
            $email = Str::lower(trim((string) $request->string('email')));
            $pass  = (string) $request->string('password');

            $user = User::where('email', $email)->first();
            return ($user && Hash::check($pass, $user->password)) ? $user : null;
        });

        Fortify::createUsersUsing(CreateNewUser::class);

        Gate::define('admin', fn (User $user) => $user->role === User::ROLE_ADMIN);
    }
}
