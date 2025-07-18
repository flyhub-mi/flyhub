<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * @OA\Info(title="FlyHub API", version="1")
 */
class AuthController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
