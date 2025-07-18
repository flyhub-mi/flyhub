<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends AuthController
{
    use SendsPasswordResetEmails;
}
