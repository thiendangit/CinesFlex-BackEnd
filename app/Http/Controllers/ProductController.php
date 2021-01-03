<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Product::with('images')->orderBy('name', 'asc')->paginate(5);
        return view('products.index', ['collection' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listType = [
            ['id' => 1, 'name'=> 'Food'], 
            ['id' => 2, 'name'=> 'Beverage']
        ];
        return view('products.create', ['collection' => $listType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only(['name', 'description', 'price', 'type']);
        $inputs['status'] = 1;
        $inputs['reference'] = 'PRO' . Str::random(6);

        $product = Product::firstOrCreate($inputs);

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/products', 'public');
            if(isset($path)) {
                $product->images()->create(['url' => '/storage/'. $path]);
            }
        }

        return redirect('products')->with('message', trans('message.products.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $produc t
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $listType = [
            ['id' => 1, 'name'=> 'Food'], 
            ['id' => 2, 'name'=> 'Beverage']
        ];

        return view('products.edit', ['model' => $product, 'collection' => $listType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $inputs = $request->only(['name', 'description', 'price', 'type']);

        $product->update($inputs);
        $product->save();

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/products', 'public');
            if(isset($path)) {
                $product->images()->update(['url' => '/storage/'. $path]);
            }
        }
    
        $product->refresh();

        return redirect('products')->with('message', trans('message.products.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->delete();
        return redirect('products')->with('message', trans('message.products.delete_success'));
    }
}
