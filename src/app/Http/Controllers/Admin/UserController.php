<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.users.index', compact('users'));
    }
}
