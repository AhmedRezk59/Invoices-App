<?php

namespace App\Http\Controllers;

use App\Invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
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
        $validated_data = $request->validate([
            'file_name'=> "mimes:pdf,jpeg,png,jpg"
        ],[
            "file_name.mimes"=> "صيغة المرفق لابد أن تكون من نوع pdf, jpeg ,.jpg , png"
        ]);

        if ($request->hasFile('file_name')) {

            $invoice_id = $request->invoice_id;
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();

            $attachments = new Invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('Attachments/' . $invoice_id), $imageName);
            session()->flash('Add' , " تم إضافة المرفق بنجاح");
        }
        return redirect("/invoicedetails/$invoice_id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoices_attachments $invoices_attachments)
    {
        //
    }
}
