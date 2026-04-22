<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Panier vide.');
        }
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total    = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('orders.checkout', compact('cart', 'products', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method'   => 'required|in:cash,card,paypal',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart.index');

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        foreach ($cart as $id => $item) {
            if ($products[$id]->stock < $item['quantity']) {
                return back()->with('error', "Stock insuffisant pour : {$products[$id]->title}");
            }
        }

        DB::transaction(function () use ($cart, $products, $request) {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $order = Order::create([
                'user_id'          => auth()->id(),
                'total'            => $total,
                'status'           => 'pending',
                'shipping_address' => $request->shipping_address,
                'payment_method'   => $request->payment_method,
            ]);

            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
                $products[$id]->decrement('stock', $item['quantity']);
            }

            session()->forget('cart');
        });

        return redirect()->route('orders.history')
                         ->with('success', 'Commande passée avec succès !');
    }

    public function history()
    {
        $orders = auth()->user()->orders()
                        ->with('items.product')
                        ->latest()
                        ->paginate(10);
        return view('orders.history', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') {
            return back()->with('error', 'Cette commande ne peut pas être annulée.');
        }
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Commande annulée.');
    }
}