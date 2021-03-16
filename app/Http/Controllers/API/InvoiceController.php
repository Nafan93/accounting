<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Company;
use App\Models\Customer;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        /*return Invoice::with(['company', 'customers', 'number'])->get();*/
   
        return Invoice::with(['company', 'customer', 'number', 'products'])->latest()->get(); 
    }

    

    public function create()
    {
        return Invoice::with(['customers', 'numbers', 'products'])->latest()->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {   
        $this->validate($request, [
            'invoice_number' => 'required',
            'date' => 'required',
            'customer_id' => 'required',
        ]);
        $invoice = Invoice::create($request->except('invoice_products'));
        
        $invoice->number()->create($request->only('invoice_number'));
        $invoice->save();

        $invoice_productsEncode = json_encode($request->invoice_products);
        $invoice_productsDecoded = json_decode($invoice_productsEncode);

        /*foreach($invoice_productsDecoded as $invoice_product) {
            return response()->json($invoice_product->line_total, 200);
        };*/

        foreach($invoice_productsDecoded as $invoice_product) {
            $invoice->invoice_products()->create([
                'product_no'    => $invoice_product->product_no,
                'product_id'    => $invoice_product->product_id,
                'product_price' => $invoice_product->product_price,
                'product_qty'   => $invoice_product->product_qty,
                'product_tax'   => $invoice_product->product_tax,
                'product_total' => $invoice_product->line_total,
            ]);
        };
       
        return response()->json($invoice, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user, $company, $invoice)
    {
        $matchThese = ['user_id'=>$user, 'company_id'=>$company, 'id'=>$invoice];
        $showInvoice = Invoice::where($matchThese)
            ->with(['acceptance_certificate',
                    'company', 'company.products', 'company.acceptance_certificates',
                    'customer', 'number', 'invoice_products'
                    ])
            ->first();
        return response()->json($showInvoice, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $user, $company, $invoice)
    {
        $invoice = Invoice::find($invoice);
        $invoice->update($request->all());
        
        return response()->json($invoice, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return response()->json([
         'message' => 'invoice deleted successfully'
        ]);
    }
}
