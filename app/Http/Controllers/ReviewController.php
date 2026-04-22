<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $exists = Review::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->exists();

        if ($exists) {
            return back()->with('error', 'Vous avez déjà évalué ce produit.');
        }

        Review::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        return back()->with('success', 'Avis ajouté. Merci !');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $review->delete();
        return back()->with('success', 'Avis supprimé.');
    }
}