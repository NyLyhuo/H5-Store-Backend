<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::where('user_id', auth()->id())
            ->with('items.product')
            ->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'shipping_address' => 'required|string',
            'phone' => 'required|string'
        ]);

        $total = 0;


        $order = Order::create([
            'user_id' => auth()->id(),
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
            'total' => 0
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $price = $product->price;
            $quantity = $item['quantity'];

            $total += $price * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $quantity,
                'price' => $price
            ]);
        }

        $order->update([
            'total' => $total
        ]);
        return response()->json($order->load('items.product'));
    }

    public function show(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            abort(403);
        }
        return $order->load('items.product');
    }
}
