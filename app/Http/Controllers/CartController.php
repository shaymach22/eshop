<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart()
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart)
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart     = $this->getCart();
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total    = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('cart.index', compact('cart', 'products', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = $this->getCart();
        $qty  = $request->quantity ?? 1;

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;
        } else {
            $cart[$product->id] = [
                'title'    => $product->title,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => $qty,
            ];
        }

        $cart[$product->id]['quantity'] = min(
            $cart[$product->id]['quantity'],
            $product->stock
        );

        $this->saveCart($cart);
        return back()->with('success', 'Produit ajouté au panier.');
    }

    public function update(Request $request, $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            $this->saveCart($cart);
        }
        return back()->with('success', 'Panier mis à jour.');
    }

    public function remove($productId)
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);
        return back()->with('success', 'Produit retiré du panier.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Panier vidé.');
    }
}