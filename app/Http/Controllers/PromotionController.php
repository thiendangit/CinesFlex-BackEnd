<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = Promotion::with('images', 'vouchers')->orderBy('title', 'asc')->paginate(5);
        return view('promotions.index', ['collection' => $model]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listType = [
            ['id' => 1, 'name'=> 'News'], 
            ['id' => 2, 'name'=> 'Discount']
        ];
        return view('promotions.create', ['collection' => $listType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->only(['title', 'description', 'type', 'date_begin', 'date_end']);
        $inputs['status'] = 1;
        $promotion = promotion::firstOrCreate($inputs);

        if($inputs['type'] == 2) { // voucher
            $inputVouchers['promotion_id'] = $promotion->id;
            $inputVouchers['reference'] = Str::random(6);
            $inputVouchers['title'] = $promotion->title;
            $inputVouchers['value'] =  $request->input('value');
            $inputVouchers['type'] = 1;
            $inputVouchers['status'] = 1;
            $modelVoucher = Voucher::firstOrCreate($inputVouchers);
            $promotion->vouchers()->save($modelVoucher);
        }
    
        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/promotions', 'public');
            if(isset($path)) {
                $promotion->images()->create(['url' => '/storage/'. $path]);
            }
        }

        return redirect('promotions')->with('message', trans('message.promotions.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        $listType = [
            ['id' => 1, 'name'=> 'News'], 
            ['id' => 2, 'name'=> 'Discount']
        ];

        return view('promotions.edit', ['model' => $promotion, 'collection' => $listType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promotion $promotion)
    {
        $inputs = $request->only(['title', 'description', 'type', 'date_begin', 'date_end']);

        $promotion->update($inputs);
        $promotion->save();

        if($promotion->type == 2) { // voucher
            $inputVouchers['value'] =  $request->input('value');
            $promotion->vouchers()->update(['value' =>  $inputVouchers['value']]);
        }

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images/promotions', 'public');
            if(isset($path)) {
                $promotion->images()->update(['url' => '/storage/'. $path]);
            }
        }
    
        $promotion->refresh();

        return redirect('promotions')->with('message', trans('message.promotions.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->images()->delete();
        $promotion->vouchers()->delete();
        $promotion->delete();
        return redirect('promotions')->with('message', trans('message.promotions.delete_success'));
    }
}
