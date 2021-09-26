<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Invoice;
use App\Invoices_attachments;
use App\Invoices_details;
use App\Notifications\AddInvoice;
use App\Notifications\PaidInvoice;
use App\Product;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Ui\Presets\React;
use PhpParser\Node\Expr\Include_;
use Symfony\Contracts\Service\Attribute\Required;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedDate = $request->validate([
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'product' => 'required',
            'Section' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',
            'pic' => 'mimes:pdf,png,jpg,jpeg',
            'value_status' => 'required'
        ], [
            "invoice_Date.required" => 'هذا الحقل مطلوب',
            "Due_date.required" => 'هذا الحقل مطلوب',
            "product.required" => 'هذا الحقل مطلوب',
            "Section.required" => 'هذا الحقل مطلوب',
            "Amount_collection.required" => 'هذا الحقل مطلوب',
            "Amount_Commission.required" => 'هذا الحقل مطلوب',
            "Discount.required" => 'هذا الحقل مطلوب',
            "Value_VAT.required" => 'هذا الحقل مطلوب',
            "Rate_VAT.required" => 'هذا الحقل مطلوب',
            "Total.required" => 'هذا الحقل مطلوب',
            "pic.mimes" => "صيغة المرفق لابد أن تكون من نوع pdf, jpeg ,.jpg , png",
            "value_status.required" => 'هذا الحقل مطلوب',
        ]);


        Invoice::create([

            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'value_status' => $request->value_status,
            'payment_date' => $request->payment_date,
            'note' => $request->note,
        ]);


        $invoice_id = Invoice::latest()->first()->id;
        Invoices_details::create([
            'invoice_id' => $invoice_id,
            'product' => $request->product,
            'Section' => $request->Section,
            'value_status' => $request->value_status,
            'note' => $request->note,
            'payment_date' => $request->payment_date,
            'user' => (Auth::user()->name),
        ]);


        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();

            $attachments = new Invoices_attachments();
            $attachments->file_name = $file_name;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_id), $imageName);
        }



       
        $users = User::get();
        
        $invoice = invoice::latest()->first();
        foreach($users as $user){
            if($user->roles_name == ['owner']){

                $user->notify(new AddInvoice($invoice));
            }

        }

        session()->flash('add', 'تم إضافة الفاتورة بنجاح');
        return redirect('/invoices');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = Invoice::findOrFail($id);
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $sections = Section::all();
        $products = Product::all();
        return view('invoices.edit_invoice', compact('invoice', 'sections', 'products', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedDate = $request->validate([
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'product' => 'required',
            'Section' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',

        ], [
            "invoice_Date.required" => 'هذا الحقل مطلوب',
            "Due_date.required" => 'هذا الحقل مطلوب',
            "Payment_Date.required" => 'هذا الحقل مطلوب',
            "product.required" => 'هذا الحقل مطلوب',
            "section_id.required" => 'هذا الحقل مطلوب',
            "Amount_collection.required" => 'هذا الحقل مطلوب',
            "Amount_Commission.required" => 'هذا الحقل مطلوب',
            "Discount.required" => 'هذا الحقل مطلوب',
            "Value_VAT.required" => 'هذا الحقل مطلوب',
            "Rate_VAT.required" => 'هذا الحقل مطلوب',
            "Total.required" => 'هذا الحقل مطلوب',
        ]);
        $invoice = Invoice::findOrFail($request->id);
        $invoice->update([

            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'value_status' => $request->value_status,
            'note' => $request->note,
        ]);
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect('/invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $details = Invoices_attachments::where('invoice_id', $request->invoice_id)->get();
        if (!empty($details)) {
            foreach ($details as $detail) {
                Storage::disk('public_uploads')->deleteDirectory($detail->invoice_id);
            }
        }
        $invoice->forceDelete();

        session()->flash('delete', 'تم حذف الفاتورة بنجاح');
        return redirect('/invoices');
    }


    public function getProducts($id)
    {
        $products = DB::table('products')->where('section_id', $id)->pluck('product_name', 'id');
        return json_encode($products);
    }

    public function Status_Update($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $validatedDate = $request->validate([
            'payment_date' => "required|date",
            'Status' => 'required'
        ], [
            'Payment_Date.required' => 'هذا الحقل مطلوب',
            'Payment_Date.date' => 'يرجى إدخال تاريخ صالح',
            'Status.required' => 'هذا الحقل مطلوب'
        ]);


        Invoices_details::create([
            'invoice_id' => $id,
            'product' => $request->product,
            'payment_date' => $request->payment_date,
            'Section' => $request->Section,
            'value_status' => $request->Status,
            'note' => $request->note,
            'user' => (Auth::user()->name)
        ]);

        $invoice->update([
            'payment_date' => $request->payment_date,

            'value_status' => $request->Status
        ]);

        session()->flash('added', 'تم تعديل حالة الدفع وتاريخ الدفع بنجاح');
        return redirect("/invoicedetails/$id");
    }



    public function show_paid_invoices()
    {
        $invoices = Invoice::where('value_status', 1)->get();

        return view('invoices.paid_invoices', compact('invoices'));
    }

    public function show_unpaid_invoices()
    {
        $invoices = Invoice::where('value_status', 2)->get();

        return view('invoices.unpaid_invoices', compact('invoices'));
    }

    public function show_partially_paid_invoices()
    {
        $invoices = Invoice::where('value_status', 3)->get();

        return view('invoices.partially_paid_invoices', compact('invoices'));
    }



    public function archive(Request $request){
        $archived_invoice = Invoice::findOrFail($request->invoice_id);
        $archived_invoice->delete();
        
        
        session()->flash('Archived', 'تم نقل الفاتورة بنجاح إلى الأرشيف');
        return redirect('/ArchivedInvoices');

    }

    public function show_archived_invoices(){
        
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive' , compact('invoices'));
    }


    public function restore_archived($id){
        Invoice::onlyTrashed()->find($id)->restore();
        session()->flash('canceledArchive','تم إلغاء أرشفة الفاتورة');
        return redirect('/invoices');
    }
    

    public function print_invoice($id){
        $invoice = Invoice::withTrashed()->findOrFail($id);
        
        return view('invoices.print_invoice' , compact('invoice'));
    }


    public function export()
    {
        return Excel::download(new InvoiceExport, 'Invoice.xlsx');
    }
}
