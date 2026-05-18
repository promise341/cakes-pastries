<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@cakesandpastries.com',
            'password' => Hash::make('password123'),
            'is_admin' => true,
        ]);

        // Create categories
        $categories = [
            ['name' => 'Cakes',                'slug' => 'cakes',                'description' => 'Freshly baked cakes for all occasions'],
            ['name' => 'Small Chops',          'slug' => 'small-chops',          'description' => 'Delicious bite-sized party snacks'],
            ['name' => 'Non-Alcoholic Drinks', 'slug' => 'non-alcoholic-drinks', 'description' => 'Refreshing drinks and beverages'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Sample products
        $products = [
            // Cakes
            ['name' => 'Classic Vanilla Birthday Cake', 'description' => 'Moist vanilla sponge with creamy buttercream frosting, perfect for any birthday celebration.', 'price' => 15000, 'category_id' => 1, 'stock' => 20, 'featured' => true],
            ['name' => 'Rich Chocolate Fudge Cake',     'description' => 'Decadent chocolate layers with silky ganache filling and chocolate buttercream.',             'price' => 18000, 'category_id' => 1, 'stock' => 15, 'featured' => true],
            ['name' => 'Strawberry Shortcake',           'description' => 'Light sponge cake with fresh strawberries and whipped cream.',                               'price' => 16000, 'category_id' => 1, 'stock' => 10, 'featured' => false],
            ['name' => 'Red Velvet Cake',                'description' => 'Classic red velvet with cream cheese frosting, a crowd favourite.',                          'price' => 17000, 'category_id' => 1, 'stock' => 12, 'featured' => true],
            ['name' => 'Lemon Drizzle Cake',             'description' => 'Zesty lemon sponge with a tangy drizzle glaze.',                                             'price' => 14000, 'category_id' => 1, 'stock' => 8,  'featured' => false],
            // Small Chops
            ['name' => 'Small Chops Platter (50 pcs)',  'description' => 'Mixed platter of puff-puff, spring rolls, samosa, and chicken skewers. Perfect for events.', 'price' => 12000, 'category_id' => 2, 'stock' => 30, 'featured' => true],
            ['name' => 'Spring Rolls (20 pcs)',          'description' => 'Crispy golden spring rolls filled with seasoned vegetables and chicken.',                    'price' => 5000,  'category_id' => 2, 'stock' => 50, 'featured' => false],
            ['name' => 'Puff-Puff (30 pcs)',             'description' => 'Soft, fluffy Nigerian puff-puff, lightly sweetened and perfectly fried.',                    'price' => 3500,  'category_id' => 2, 'stock' => 60, 'featured' => false],
            ['name' => 'Samosa (20 pcs)',                'description' => 'Golden pastry parcels filled with spiced minced meat and vegetables.',                       'price' => 5500,  'category_id' => 2, 'stock' => 40, 'featured' => false],
            ['name' => 'Chicken Skewers (10 pcs)',       'description' => 'Tender grilled chicken skewers marinated in aromatic spices.',                              'price' => 7000,  'category_id' => 2, 'stock' => 25, 'featured' => true],
            // Drinks
            ['name' => 'Chapman Cocktail (1L)',          'description' => 'Classic Nigerian Chapman with Angostura bitters, Fanta, Sprite, and fresh fruits.',          'price' => 3000,  'category_id' => 3, 'stock' => 50, 'featured' => true],
            ['name' => 'Zobo Drink (500ml)',             'description' => 'Traditional hibiscus flower drink, chilled and spiced with ginger and cloves.',              'price' => 1500,  'category_id' => 3, 'stock' => 80, 'featured' => false],
            ['name' => 'Fruit Punch (1L)',               'description' => 'Refreshing blend of tropical fruits — mango, pineapple, and passion fruit.',                 'price' => 2500,  'category_id' => 3, 'stock' => 40, 'featured' => false],
            ['name' => 'Kunu Drink (500ml)',             'description' => 'Creamy millet-based Nigerian kunu with a hint of ginger.',                                   'price' => 1200,  'category_id' => 3, 'stock' => 60, 'featured' => false],
        ];

        foreach ($products as $product) {
            Product::create(array_merge($product, [
                'slug'   => Str::slug($product['name']),
                'status' => 'active',
                'image'  => null,
            ]));
        }
    }
}
