<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Section;
use App\Status;
use Illuminate\Http\Request;

class InvoicesReport extends Controller
{
    public function index()
    {
        return view('report.invoices_report');
    }


    public function search(Request $request)
    {

        $request->validate([
            "type" => 'required'
        ], [
            'type.required' => 'حقل نوع الفاتورة مطلوب'
        ]);

        if ($request->start_at == '' && $request->end_at == '') {
            $invoices = Invoice::where('value_status', $request->type)->get();
        } else {
            $invoices = Invoice::where('value_status', $request->type)->whereBetween('invoice_Date', [$request->start_at, $request->end_at])->get();
        }
        $type = $request->type;



        if ($type == 0) {
            $Alphatype = 'كل الفواتير';
        } else {
            $Alphatype = Status::where('id', $type)->first()->name;
        }
        return view('report.invoices_report', compact('invoices', 'type', 'Alphatype'));
    }

    
}
