<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\MovieScreen;
use App\Models\Seat;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Get history
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchHistory(Request $request)
    {
        $inputs = $request->all();
        $user_id = Auth::user()->id;
        $user = User::whereId($user_id)->with('orders', 'orders.details')->get();

        $response = [
            'data' => $user,
            'message' => 'Get list successfully',
            'success' => true
        ];
        return response($response);
    }

    /**
     * Book ticket
     *
     * @return \Illuminate\Http\Response
     */
    public function bookingTicket(Request $request)
    {
        $inputs = $request->all();

        $check = $this->checkExist($inputs, ['show_time', 'seat_ids']);
        if($check['failed'] === true)
        {
            return $response = [
                'message' => 'Required ' . $check['message'],
                'success' => false,
            ];
            return response($response);
        }
        $checkMovieScreen = $this->checkMovieScreenExist($inputs['show_time']);
        if($checkMovieScreen['failed'] === true) {
            return $response = [
                'message' => 'Required ' . $checkMovieScreen['message'],
                'success' => false
            ];
            return response($response);
        }
        $show_time_price = $checkMovieScreen['price'];

        $inputs['booker_id'] = Auth::id();
        $listProduct = [];
        $products = [];
        $totalProduct = 0;
        if(isset($inputs['products'])) {
            foreach($inputs['products'] as $productInput) {
                $product = Product::find($productInput['product_id']);
                $totalProduct += ($product->price * $productInput['product_quantity']) ?? 0;
                array_push($listProduct, $product);

                if(!isset($products[$product->id])){
                    $products[$product->id] = $productInput['product_quantity'];
                }

            }
        }

        $listTicket = [];
        $totalTicket = 0;
        foreach($inputs['seat_ids'] as $seat_id) {
            $ticket = Ticket::create([
                'booker_id' => $inputs['booker_id'],
                'movie_screen_id' => $inputs['show_time'],
                'seat_id' => $seat_id,
                'reference' => 'TIC' . Str::random(6),
                'price' => $moviePrice ?? 50000,
            ]);
            $seat = Seat::whereId($seat_id)->update(['type' => Seat::IS_AVAILABLE]);
            $totalTicket += $moviePrice ?? 50000;
            array_push($listTicket, $ticket);
        }

        if(sizeof($listTicket) > 0) {
            $order = Order::create([
                'reference' => 'ORD' . Str::random(6),
                'paid' => array_sum(array_column($listTicket, 'price')) + $totalProduct,
                'total_paid' => array_sum(array_column($listTicket, 'price')) + $totalProduct,
                'type' => 1,
                'status' => 1
            ]);

            if(isset($order)) {
                foreach($listTicket as $ticket) {
                    $orderDetails = OrderDetail::create([
                        'order_id' => $order->id,
                        'order_detailable_id' => $ticket->id,
                        'order_detailable_type' => Ticket::class,
                        'quantity' => 1,
                        'total' => $ticket->price
                    ]);
                }

                if(sizeof($listProduct) > 0) {
                    foreach($listProduct as $product) {
                        $orderDetails = OrderDetail::create([
                            'order_id' => $order->id,
                            'order_detailable_id' => $product->id,
                            'order_detailable_type' => Product::class,
                            'quantity' => $products[$product->id],
                            'total' => $product->price * $products[$product->id]
                        ]);
                    }
                }

            }
        }

        $response = [
            'data' => $listTicket,
            'message' => 'Create Order Successfully',
            'success' => true
        ];
        return response($response);
    }

    private function getTotalProduct($inputs) {
        return [];
    }

    private function checkMovieScreenExist($show_time_id) {
        $movieScreen = MovieScreen::find($show_time_id);
        if(isset($movieScreen)){
            $moviePrice = $movieScreen->movie->detail->price;
            return [
                'failed' => false,
                'price' => $moviePrice
            ];
        }

        return [
            'failed' => true,
            'message' => 'Show time is not exist',
        ];
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
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
