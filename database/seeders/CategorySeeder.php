<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Électronique',  'slug' => 'electronique',  'description' => 'Appareils électroniques'],
            ['name' => 'Vêtements',     'slug' => 'vetements',     'description' => 'Mode et habillement'],
            ['name' => 'Maison',        'slug' => 'maison',        'description' => 'Décoration et mobilier'],
            ['name' => 'Sport',         'slug' => 'sport',         'description' => 'Équipement sportif'],
            ['name' => 'Alimentation',  'slug' => 'alimentation',  'description' => 'Produits alimentaires'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}