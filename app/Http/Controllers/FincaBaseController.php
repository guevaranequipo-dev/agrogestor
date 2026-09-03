<?php

namespace App\Http\Controllers;

use App\Models\Finca;
use Illuminate\Support\Facades\Auth;

class FincaBaseController extends Controller
{
    protected function verificarPropietario(Finca $finca)
    {
        if ($finca->user_id !== Auth::id()) {
            abort(403);
        }
    }
}