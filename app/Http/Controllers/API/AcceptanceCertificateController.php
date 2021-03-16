<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AcceptanceCertificate;
use Illuminate\Http\Request;

class AcceptanceCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $certificate = AcceptanceCertificate::create($request->all());
        $certificate->save();
        return response()->json($certificate, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcceptanceCertificate  $acceptanceCertificate
     * @return \Illuminate\Http\Response
     */
    public function show($user, $company, $acceptance_certificate)
    {
        $matchThese = ['user_id'=>$user, 'company_id'=>$company, 'id'=>$acceptance_certificate];
        $certificate = AcceptanceCertificate::where($matchThese)
            ->with([
            'company.products', 'invoice', 'invoice.company', 'invoice.customer', 'invoice.number',
            'invoice.invoice_products'
             ])
            ->first();
        return response()->json($certificate, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcceptanceCertificate  $acceptanceCertificate
     * @return \Illuminate\Http\Response
     */
    public function edit(AcceptanceCertificate $acceptanceCertificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcceptanceCertificate  $acceptanceCertificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcceptanceCertificate $acceptanceCertificate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcceptanceCertificate  $acceptanceCertificate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $certificate = AcceptanceCertificate::findOrFail($id);
        $certificate->delete();
        return response()->json($certificate, 200);
    }
}
