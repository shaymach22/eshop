<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $stats = [
            'products'   => Product::count(),
            'orders'     => Order::count(),
            'users'      => User::count(),
            'categories' => Category::count(),
            'revenue'    => Order::where('status', 'validated')->sum('total'),
            'pending'    => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}