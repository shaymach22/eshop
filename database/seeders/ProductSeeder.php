<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all();

        $products = [
            ['title' => 'iPhone 15 Pro', 'price' => 1299.99, 'stock' => 50],
            ['title' => 'Samsung Galaxy S24', 'price' => 999.99, 'stock' => 30],
            ['title' => 'MacBook Pro M3', 'price' => 2499.99, 'stock' => 20],
            ['title' => 'Nike Air Max', 'price' => 129.99, 'stock' => 100],
            ['title' => 'Adidas Ultraboost', 'price' => 149.99, 'stock' => 80],
            ['title' => 'Canapé 3 places', 'price' => 599.99, 'stock' => 15],
            ['title' => 'Vélo de route', 'price' => 799.99, 'stock' => 25],
            ['title' => 'T-shirt Premium', 'price' => 29.99, 'stock' => 200],
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $categories->random()->id,
                'title'       => $product['title'],
                'slug'        => Str::slug($product['title']),
                'description' => 'Description de ' . $product['title'],
                'price'       => $product['price'],
                'stock'       => $product['stock'],
                'is_active'   => true,
            ]);
        }
    }
}