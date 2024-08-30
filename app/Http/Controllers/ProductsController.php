<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::all();
        $products = products::all();
        return view('products.products', compact('sections', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'Product_name' => 'required',
            'description' => 'required',
            'section_id' => 'required',
        ], [
            'Product_name.required' => 'يرجى ادخال اسم القسم',
            'description.required' => 'يرجى ادخال البيان',
            'section_id.required' => 'يرجى اختيار القسم',
        ]);
        products::create([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $request->section_id,
        ]);
        session()->flash('Add', 'تم اضافه المنتج بنجاح');
        return redirect('product');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $product_id = $request->pro_id;
        $section_id=sections::where('section_name',$request->section_name)->first()->id;


        $this->validate($request, [

            'Product_name' => 'required',
            'description' => 'required',

        ], [
            'Product_name.required' => 'يرجى ادخال اسم المنتج',
            'description.required' => 'يرجى ادخال البيان',

        ]);
        $product = products::find($product_id);
        $product->update([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $section_id,
        ]);
        session()->flash('Edit', 'تم تعديل المنتج بنجاج');
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->pro_id;
        products::find($id)->delete();
        session()->flash('Delete', 'تم حذف القسم بنجاح');
        return redirect('/products');
    }
}
