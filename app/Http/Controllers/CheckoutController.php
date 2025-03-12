<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class CheckoutController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Retrieve cart from session
        $cart = session()->get('cart', []);
        $subtotal = 0;

        // Calculate subtotal
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        // Static shipping cost (you can integrate real API here)
        $ongkir = 10000;
        $total = $subtotal + $ongkir;

        // Send data to checkout view
        return view('users.payment-confirmation', compact('cart', 'subtotal', 'ongkir', 'total'));
    }

    public function processCheckout(Request $request)
{
    // Check if user is logged in
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Validate input
    $request->validate([
        'recipient_name' => 'required',
        'email' => 'required|email',
        'address' => 'required',
    ]);

    // Calculate subtotal and shipping cost
    $subtotal = 0;
    $cart = session()->get('cart', []); // Get cart from session
    foreach ($cart as $item) {
        $subtotal += $item['harga'] * $item['jumlah'];
    }
    $ongkir = 10000;
    $total = $subtotal + $ongkir;

    // Create a new order
    $order = Order::create([
        'order_id' => (string) Str::uuid(),
        'user_id' => Auth::id(),
        'recipient_name' => $request->input('recipient_name'),
        'email' => $request->input('email'),
        'address' => $request->input('address'),
        'message' => $request->input('message'),
        'subtotal' => $subtotal,
        'shipping_cost' => $ongkir,
        'total' => $total,
        'payment_status' => 'pending',
    ]);

    // Configure Midtrans
    Config::$serverKey = env('MIDTRANS_SERVER_KEY');
    Config::$isProduction = false;
    Config::$isSanitized = true;
    Config::$is3ds = true;

    // Create transaction details
    $transaction_details = [
        'order_id' => $order->order_id,
        'gross_amount' => $order->total,
    ];

    // Prepare item details for Midtrans
    $item_details = [];
    foreach ($cart as $item) {
        $item_details[] = [
            'id' => $item['id_produk'],
            'price' => $item['harga'],
            'quantity' => $item['jumlah'],
            'name' => $item['nama_produk'],
        ];
    }

    // Customer details
    $customer_details = [
        'first_name' => $order->recipient_name,
        'email' => $order->email,
        'address' => $order->address,
    ];

    // Build the Midtrans payload
    $params = [
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details,
    ];

    // Generate Snap token
    $snapToken = Snap::getSnapToken($params);
    $order->snap_token = $snapToken;
    $order->save();

    // Simpan setiap item dalam keranjang ke tabel transaksi dan kurangi stok produk
    foreach ($cart as $item) {
        \DB::table('transaksi')->insert([
            'user_id' => Auth::id(),
            'id_produk' => $item['id_produk'],
            'recipient_name' => $request->input('recipient_name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'subtotal' => $item['harga'] * $item['jumlah'],
            'shipping_cost' => $ongkir,
            'total' => ($item['harga'] * $item['jumlah']) + $ongkir,
            'quantity' => $item['jumlah'],
            'payment_status' => 'pending',
            'snap_token' => $snapToken,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Kurangi stok produk
        $product = Product::find($item['id_produk']);
        if ($product && $product->stok !== null) {
            $product->stok = max(0, $product->stok - $item['jumlah']); // Pastikan stok tidak negatif
            $product->save();
        }
    }

    // Redirect to payment page with Snap token
    return view('payment', ['snapToken' => $snapToken, 'order' => $order]);
}



    

    public function checkout($orderId)
    {
        // Log the order ID
        Log::info('Order ID: ' . $orderId);

        // Find the order or throw 404
        $order = Order::findOrFail($orderId);

        // Show the checkout page
        return view('checkout', compact('order'));
    }

    public function success($orderId)
{
    // Cari order berdasarkan order_id
    $order = Order::where('order_id', $orderId)->firstOrFail();

    // Ubah status pembayaran menjadi success
    $order->payment_status = 'success';
    $order->save();
    

    // Tampilkan halaman payment-success
    return view('payment-success', compact('order'));
}


    public function history()
    {
        // Get all orders
        $orders = Order::all();
        return view('orderHistory', ['orders' => $orders]);
    }
}
