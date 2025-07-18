<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends AuthController
{
    use ResetsPasswords;

    protected $redirectTo = RouteServiceProvider::HOME;
}
