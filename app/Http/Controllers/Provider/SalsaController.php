<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Traits\Providers\SalsaGamesTrait;
use Illuminate\Http\Request;

class SalsaController extends Controller
{
    use SalsaGamesTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function webhookMethod(Request $request)
    {
        return self::webhookSalsa($request);
    }
}
