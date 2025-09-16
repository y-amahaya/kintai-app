<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return new JsonResponse('', 204);
        }

        // 管理者ログイン
        if ($request->has('is_admin_login')) {
            return redirect()->route('admin.attendance.index');
        }

        // 一般ユーザーログイン
        return redirect()->intended(config('fortify.home'));
    }
}
