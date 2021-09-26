<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Invoices_attachments;
use App\Invoices_details;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        // $sections = Section::all();
        $details = Invoices_details::where('invoice_id', $id)->get();
        $attachments = Invoices_attachments::where('invoice_id', $id)->get();
        return view('invoices.invoices_details', compact('invoice', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        Storage::disk('public_uploads')->delete($request->invoice_id . DIRECTORY_SEPARATOR . $request->file_name);
        Invoices_attachments::findOrFail($request->id_file)->delete();
        session()->flash('delete' , 'تم حذف المرفق بنجاح');
        return back();
    }

  

    public function download_file($invoice_id, $file_name)
    {
        return  Storage::disk('public_uploads')->download("$invoice_id/$file_name" , $file_name);
        
    }
}
