<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    
    public function index()
    {
        return Company::latest()->get();
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
            'kpp' => 'required',
            'inn' => 'required',
        ]);

        return Company::create($request->all());
    }

    public function show($user, $company)
    {
        $matchThese = ['user_id'=>$user, 'id'=>$company];
        return Company::where($matchThese)->with([
            'invoices', 'invoices.number', 'invoices.customer', 'invoices.acceptance_certificate', 'invoices.invoice_products', 
            'customers', 'numbers',
            'products', 'products.product_category', 'product_categories',
            'acceptance_certificates', 'acceptance_certificates.customer', 'acceptance_certificates.invoice', 'acceptance_certificates.invoice.number'
            ])
             ->first();
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
            'kpp' => 'required',
            'inn' => 'required',
        ]);

        $company = Company::findOrFail($id);

        $company->update($request->all());
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json([
         'message' => 'company deleted successfully'
        ]);
    }
}