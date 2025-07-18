<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\BaseController;

class TokensController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index()
    {
        return view('tenant.settings.tokens.index');
    }
}
