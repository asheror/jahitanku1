<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersayaController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter berdasarkan email jika ada
        if ($request->has('email') && $request->email != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        // Filter berdasarkan recipient_name jika ada
        if ($request->has('recipient_name') && $request->recipient_name != '') {
            $query->where('recipient_name', 'like', '%' . $request->recipient_name . '%');
        }

        // Filter berdasarkan payment_status jika ada
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Ambil data berdasarkan filter yang diterapkan
        $orders = $query->get();

        return view('admin.OrdersManagement', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recipient_name' => 'required|string',
            'email' => 'nullable|email',
            'message' => 'nullable|string',
            'subtotal' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'total' => 'required|numeric',
            'payment_status' => 'nullable|in:pending,success,failed',
        ]);

        Order::create($request->all());

        return redirect()->route('orders.index')->with('success', 'Order added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'recipient_name' => 'required|string',
            'email' => 'nullable|email',
            'message' => 'nullable|string',
            'subtotal' => 'required|numeric',
            'shipping_cost' => 'required|numeric',
            'total' => 'required|numeric',
            'payment_status' => 'nullable|in:pending,success,failed',
        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
