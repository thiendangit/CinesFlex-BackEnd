<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListByType(Request $request)
    {
        $inputs = $request->all();

        $check = $this->checkExist($inputs, ['type']);
        if($check['failed'] === true)
        {
            return $response = [
                'message' => 'Required ' . $check['message'],
                'success' => false,
            ];
            return response($response);
        }

        $data = Product::where('type', $inputs['type'])->get();
        $response = [
            'data' => $data,
            'message' => 'Get list successfully',
            'success' => true
        ];
        return response($response);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all();
        $response = [
            'data' => $data,
            'message' => 'Get list successfully',
            'success' => true
        ];
        return response($response);
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
     * @param  \App\Models\Product  $product
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    private function checkExist($inputs, array $array) {
        foreach($array as $key){
            if(!isset($inputs[$key])){
                return [
                    'failed' => true,
                    'message' => $key
                ];
            }
        }
        return [
            'failed' => false
        ];
    }
}
