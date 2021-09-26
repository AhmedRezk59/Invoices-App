<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Section;
use Illuminate\Http\Request;

class CustomersReport extends Controller
{
    public function index()
    {

        $sections = Section::all();

        return view('report.customers_report', compact('sections'));
    }

    public function search(Request $request)
    {
        $request->validate([
            "product" => 'required',
            "section" => 'required',
        ], [
            'section.required' => 'حقل القسم مطلوب',
            'product.required' => 'حقل المنتج مطلوب',
        ]);

        if ($request->section && $request->product && $request->start_at == '' && $request->end_at == '') {
            $invoices = Invoice::where('section_id', $request->section)->where('product', $request->product)->get();
        } else {
            $invoices = Invoice::where('section_id', $request->section)->where('product', $request->product)->whereBetween('invoice_Date', [$request->start_at, $request->end_at])->get();
        }
        $sections = Section::all();
        return view('report.customers_report', compact('invoices', 'sections'));
    }
}
