<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class GiftController extends Controller
{
    public function getGift(Request $request)
    {
        $inputs = $request->all();
        $user = Auth::user();

        $check = $this->checkExist($inputs, ['gift_id']);
        if($check['failed'] === true)
        {
            return $response = [
                'message' => 'Required ' . $check['message'],
                'success' => false,
            ];
            return response($response);
        }
        $gift = Gift::whereId($inputs['gift_id'])->first();
        
        if(isset($gift)){
            if($user->point >= $gift->coin) {
                $point_amount = $user->point - $gift->coin;
                $modelVoucher = new Voucher();
                $modelVoucher->reference = Str::random(6);
                $modelVoucher->title = $gift->title;
                $modelVoucher->value = $gift->discount;
                $modelVoucher->type = 1;
                $modelVoucher->status = 1;
                $modelVoucher->save();
                
                $user->point = $point_amount;
                $user->save();

                $response = [
                    'data' => $modelVoucher,
                    'message' => 'Get gift successfully',
                    'success' => true
                ];
            } else {
                $response = [
                    'data' => null,
                    'message' => 'User not enable coin',
                    'success' => false
                ];
            }
        } else {
            $response = [
                'data' => null,
                'message' => 'Gift is not found',
                'success' => false
            ];
        }
        
        return response($response);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Gift::with('images')->get();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
