<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatistiquesController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperviseur()) {
            abort(403);
        }

        return view('statistiques.index');
    }
}
