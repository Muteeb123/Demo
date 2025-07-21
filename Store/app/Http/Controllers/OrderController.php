<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $query = Order::with(['product', 'user']);

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
    public function store(Request $request,Product $product)
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
