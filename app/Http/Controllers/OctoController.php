<?php

namespace App\Http\Controllers;

use App\Repositories\User;
use Illuminate\Http\Request;
use App\Services\OctoService;

class OctoController extends Controller
{

    public function __invoke(Request $request, OctoService $octo)
    {
        return response()->json($octo->process($request->all()));
    }

}
