<?php

namespace App\Http\Controllers;

use App\Product;
use App\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('products.products' , compact('sections' , 'products'));
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
        $validatedData = $request->validate([
            'product_name' => 'required|max:100',
            "section_id" =>'required'
        ],[
            'product_name.required' => 'يرجى إدخال اسم المنتج',
            "section_id.required" => "يرجى إدخال اسم القسم"
        ]);

        Product::create([
            "product_name" => $request->product_name,
            "description"=> $request->description,
            'section_id' => $request->section_id
        ]);

        session()->flash('Add' , 'تم إضافة المنتج بنجاح');
        return redirect('/products');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Section::where('id', $request->section_id)->get()->first()->id;
       $product_id = $request->id;
        $validatedData = $request->validate([
            'product_name' => 'required|max:100',
            "section_id" => 'required'
        ], [
            'product_name.required' => 'يرجى إدخال اسم المنتج',
            "section_id.required" => "يرجى إدخال اسم القسم"
        ]);

        Product::find($product_id)->update([
            "product_name" => $request->product_name,
            "description" => $request->description,
            'section_id' => $request->section_id
        ]);

        session()->flash('edit', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Product::find($request->id)->delete();
        session()->flash('delete', 'تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
