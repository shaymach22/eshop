<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews'])
                        ->where('is_active', true);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        switch ($request->sort) {
            case 'price_asc':  $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            default:           $query->latest(); break;
        }

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view('catalog.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user']);
        $related = Product::where('category_id', $product->category_id)
                          ->where('id', '!=', $product->id)
                          ->limit(4)->get();
        return view('catalog.show', compact('product', 'related'));
    }
}