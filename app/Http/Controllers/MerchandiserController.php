<?php

namespace App\Http\Controllers;

use App\Models\Merchandiser;
use Illuminate\Http\Request;

class MerchandiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $merchandisers = Merchandiser::with('orders')->latest()->paginate(5);

        return view('merchandisers.index', compact('merchandisers'))
        ->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('merchandisers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        Merchandiser::create($request->all());

        return redirect()->route('merchandisers.index')
                        ->with('success','Merchandiser created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchandiser  $merchandiser
     * @return \Illuminate\Http\Response
     */
    public function show(Merchandiser $merchandiser)
    {
        return view('merchandisers.show',compact('merchandiser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchandiser  $merchandiser
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchandiser $merchandiser)
    {
        return view('merchandisers.edit',compact('merchandiser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merchandiser  $merchandiser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchandiser $merchandiser)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $merchandiser->update($request->all());

        return redirect()->route('merchandisers.index')
                        ->with('success','Merchandiser updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merchandiser  $merchandiser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchandiser $merchandiser)
    {
        $merchandiser->delete();

        return redirect()->route('merchandisers.index')
                        ->with('success','Merchandiser deleted successfully');
    }
}