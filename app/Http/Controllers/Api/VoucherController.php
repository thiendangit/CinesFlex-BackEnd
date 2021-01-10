<?php

namespace App\Http\Controllers\Api;

use App\Models\Voucher;
use Carbon\Carbon;

use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * apply voucher.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function apply(Request $request)
    {
        $inputs = $request->all();
        $voucher = Voucher::where('reference', $inputs['code'])->where('status', 1)->with('promotion')->first();

        if (isset($voucher)) {
            $now = Carbon::now();

            if (isset($voucher->promotion->date_begin) || isset($voucher->promotion->date_end)) {
                if ($now->lt($voucher->promotion->date_begin) || $now->gt($voucher->promotion->date_end)) {
                    return [
                        'data' => $voucher,
                        'message' => 'Voucher is expired',
                        'success' => false
                    ];
                }
            }
            
            $response = [
                'data' => $voucher,
                'message' => 'Apply voucher successfully',
                'success' => true
            ];
        } else {
            $response = [
                'message' => 'Voucher is not valid',
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
        //
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Voucher $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Voucher $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Voucher $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Voucher $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}
