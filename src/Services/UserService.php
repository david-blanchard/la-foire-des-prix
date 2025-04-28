<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function isAdmin(): bool
    {
        $result = false;
        $user = Auth::user();

        $result = $user !== null ? $user->role === User::ADMIN_ROLE : false;

        return $result;
    }
}
