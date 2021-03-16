<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;

class IndexController extends Controller
{
      
     public function index()
     {
        $invoices = Invoice::all();
        return view('home')->with([
            'invoices' => $invoices
        ]);
     }
}
