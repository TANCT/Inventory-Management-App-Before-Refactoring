<?php

namespace App\Http\Controllers;


use App\Models\Product;
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
        $products = Product::where('quantity', '>', 0)
        -> where('isDisposed', '=', false)
        ->latest()
        ->paginate(5);
       
        //calculate the total price considering the discount
        foreach ($products as $product) {
            if($product->discount>0)
            {
                $product->totalPrice = $product->price - 
                ($product->price * $product->discount / 100);
            }
            else{
                $product->totalPrice=$product ->price;
            }   
        }
        //check if it is clearance sale
        foreach ($products as $product) {
            $product->isClearance = $product->discount >= 50;
        }
        return view('products.index',compact('products'))
            ->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     * Example of product ={
     * name: apple,
     * detail:fuji,
     * quantity:10,
     * discount:5,
     * price:2
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'quantity' => 'required|numeric',
            'discount' => 'required|numeric',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],

        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'quantity' => 'required|numeric',
            'discount' => 'required|numeric',
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function dispose(Product $product)
{
    $product->isDisposed = true;
    $product->update(['isDisposed' => true]);

    return redirect()->route('products.index')
                    ->with('success', 'Product disposed successfully');
}

}