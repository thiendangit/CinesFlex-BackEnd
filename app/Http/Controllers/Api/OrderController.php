<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\MovieScreen;
use App\Models\Seat;
use App\Models\User;
use App\Models\Voucher;

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
        $userId = Auth::id();
        // $user = User::whereId($user_id)->with('orders', 'orders.details')->get();

        $data = [];
        $listOrder = Order::where('booker_id', $userId)->with('details', 'details.order_detailable')->get();
        if(sizeof($listOrder) > 0) {
            // $listOrderId = array_column($listOrder, 'id');
            // $item = OrderDetail::whereIn('order_id', $listOrderId)->get();

        }
        
        $response = [
            'data' => $listOrder,
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
        $getTickPrice = $this->getTickPrice($inputs['show_time']);
        if($getTickPrice['failed'] === true) {
            return $response = [
                'message' => 'Required ' . $getTickPrice['message'],
                'success' => false
            ];
            return response($response);
        }

        $inputs['booker_id'] = Auth::id();
        $ticketPrice = $getTickPrice['price'];
        $tickets = $this->addTicket($inputs, $ticketPrice);
        $products = $this->getProduct($inputs['products']);

        $total_ticket = array_sum(array_column($tickets, 'price')) ?? 0;
        $total_product = array_sum(array_column($products, 'total')) ?? 0;

        $total_paid_discount = 0;
        if(isset($inputs['voucher_id'])) {
            $voucher = Voucher::where('id', $inputs['voucher_id'])->where('status', 1)->first();
        }
        if(isset($voucher)) {
            $total_paid_discount = ($total_ticket + $total_product) * $voucher->value / 100;
        }

        $order = Order::create([
            'voucher_id' => isset($inputs['voucher_id']) ? $inputs['voucher_id'] : null,
            'booker_id' => $inputs['booker_id'],
            'reference' => 'ORD' . Str::random(6),
            'paid' => $total_ticket + $total_product,
            'total_paid' => $total_ticket + $total_product - $total_paid_discount,
            'type' => 1,
            'status' => 1
        ]);

        if(isset($order)) {
            $orderId = $order->id;
            foreach($tickets as $ticket) {
                $orderDetails = OrderDetail::create([
                    'order_id' => $orderId,
                    'order_detailable_id' => $ticket->id,
                    'order_detailable_type' => Ticket::class,
                    'quantity' => 1,
                    'total' => $ticket->price
                ]);
                $order->details()->save($orderDetails);
            }
            
            if(sizeof($products) > 0) {
                foreach($products as $product) {
                    $orderDetails = OrderDetail::create([
                        'order_id' => $orderId,
                        'order_detailable_id' => $product['id'],
                        'order_detailable_type' => Product::class,
                        'quantity' => $product['quantity'],
                        'total' => $product['price'] * $product['quantity']
                    ]);
                    $order->details()->save($orderDetails);
                }
            }

        }
        
        $response = [
            'data' => $order,
            'message' => 'Create Order Successfully',
            'success' => true
        ];
        return response($response);
    }

    private function getProduct(array $inputs) {
        $products = [];
        foreach($inputs as $productInput) {
            $product = Product::find($productInput['product_id']);
            array_push($products, [
                'id' => $product->id,
                'quantity' => $productInput['product_quantity'],
                'price' => $product->price,
                'total' => $productInput['product_quantity'] * $product->price 
            ]);
        }

        return $products;
    }

    private function addTicket($inputs, $ticketPrice) {
        $tickets = [];
        foreach($inputs['seat_ids'] as $seat_id) {
            $ticket = Ticket::create([
                'booker_id' => $inputs['booker_id'],
                'movie_screen_id' => $inputs['show_time'],
                'seat_id' => $seat_id,
                'reference' => 'TIC' . Str::random(6),
                'price' => $ticketPrice ?? 50000,
            ]);
            $seat = Seat::whereId($seat_id)->update(['type' => Seat::IS_AVAILABLE]);
            array_push($tickets, $ticket);
        }
        return $tickets;
    }

    private function getTickPrice($showTimeId) {
        $movieScreen = MovieScreen::find($showTimeId);
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
