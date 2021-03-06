<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Number;

class NumberController extends Controller
{
    public function index()
    {
        return Number::with('invoice')->get();
    }
}
