<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        

        $query = Order::with(['product', 'user']);
        if ($search = $request->search) {
                $query->where(function($query) use ($search){
                    $query->whereHas('user',function ($q)  use ($search){
                        $q->where('name','like', "%{$search}%");
                    })->orWhereHas('product' ,function ($q)use ($search){
                        $q->where('name', 'like', "%{$search}%" )->withTrashed();
                    });
                });
            }

        
        if ($status = $request->status)
        {
            $query->where('status',$request->status);

        }
        if ($request->has('sortby')) {
            $sortBy = $request->sortby;
          

            $sortMap = [
              
                'price_asc' => ['total_price', 'asc'],
                'price_desc' => ['total_price', 'desc'],
                'newest'=>['created_at','desc'],
                'oldest'=>['created_at','asc']
            ];

            if (isset($sortMap[$sortBy])) {
                $query->orderBy($sortMap[$sortBy][0], $sortMap[$sortBy][1]);
            } else {
                $query->latest(); // default fallback
            }
        }

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::user()->id);
        }
        

        $orders = $query->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Product $product)
    {
        //
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
        ]);


        $order = Order::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'user_id' => Auth::user()->id,
            'total_price' => $product->price * $request->quantity,
            'tracking_number' => 'ORD-' . strtoupper(uniqid()),
        ]);

        return $order ? true : false;
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //

        if ($order->status== 'cancelled'){
            return redirect()->back()->with('error','Order has been Cancelled');
        }
        $order->status = 'completed';
        $order->save();
        return redirect()->back()->with('success','Marked as Completed!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
       
        

        if ($order->status == 'cancelled'|| $order->status == 'completed') {
            return redirect()->back()->with('error', 'Order Already Cancelled or is Completed');
        }
        $product= $order->product;
        $product->stock = $product->stock+ $order->quantity;
        Log::info('Stock: '. $product->stock);
        $product->save();
        $order->status = 'cancelled';
        $order->save();
        return redirect()->back()->with('error', 'Order cancelled.');
    
    }


}
