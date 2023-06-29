<?php

namespace App\Http\Controllers;
use App\Models\DisposedProduct;
use Illuminate\Http\Request;

class DisposedController extends ProductController{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = DisposedProduct::where('quantity', '>', 0)
        -> where('isDisposed', '=', true)
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
        return view('disposedproducts.index', compact('products'))
            ->with(request()->input('page'));
    }

    
}
