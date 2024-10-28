<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Report;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'order_date' => 'required|date',
        ]);

        $order = Order::create($request->only('customer_name', 'order_date'));

        return redirect()->route('orders.show', $order->id);
    }

    public function show(Order $order)
    {
        $products = Product::all();
        return view('orders.show', compact('order', 'products'));
    }

    public function addDetail(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Insufficient stock for the selected product.');
        }

        $product->stock -= $request->quantity;
        $product->save();

        $order->details()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->price * $request->quantity,
        ]);

        Report::create([
            'product_id' => $product->id,
            'quantity_out' => $request->quantity,
            'transaction_date' => now(),
            'type' => 'out',
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Product added to order and stock updated successfully');
    }


    public function editDetail(Request $request, Order $order, $detailId)
    {
        $request->validate([
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        $detail = $order->details()->findOrFail($detailId);
        $product = $detail->product;

        $quantityDifference = $request->quantity - $detail->quantity;

        if ($quantityDifference > 0 && $product->stock < $quantityDifference) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Insufficient stock for the selected product.');
        }

        $product->stock -= $quantityDifference;
        $product->save();

        $detail->update([
            'price' => $request->price,
            'quantity' => $request->quantity,
            'total' => $request->price * $request->quantity,
        ]);

        Report::create([
            'product_id' => $product->id,
            'quantity_out' => $quantityDifference > 0 ? $quantityDifference : 0,
            'quantity_in' => $quantityDifference < 0 ? abs($quantityDifference) : 0,
            'transaction_date' => now(),
            'type' => $quantityDifference > 0 ? 'out' : 'in',
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Product updated successfully.');
    }


    public function deleteDetail(Order $order, $detailId)
    {
        $detail = $order->details()->findOrFail($detailId);
        $product = $detail->product;

        $product->stock += $detail->quantity;
        $product->save();

        $detail->delete();

        Report::create([
            'product_id' => $product->id,
            'quantity_in' => $detail->quantity,
            'transaction_date' => now(),
            'type' => 'in',
        ]);

        return redirect()->route('orders.show', $order->id)->with('success', 'Product removed from order and stock updated.');
    }
}
