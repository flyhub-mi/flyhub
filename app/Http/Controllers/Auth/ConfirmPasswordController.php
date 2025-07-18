<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends AuthController
{
    use ConfirmsPasswords;

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * ConfirmPasswordController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
