<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UpdateProductsSeeder extends Seeder
{
    protected $categoryNames = [
        'Birthday Cakes' => [
            'Classic Chocolate Birthday Cake',
            'Rainbow Sprinkles Birthday Cake',
            'Red Velvet Birthday Cake',
            'Funfetti Birthday Cake',
            'Oreo Cookies & Cream Cake',
            'Strawberry Shortcake',
            'Black Forest Cake',
            'Pinata Cake',
            'Drip Cake with Macarons',
            'Unicorn Birthday Cake',
            'Mermaid Tail Cake',
            'Number Shaped Cake',
            'Superhero Theme Cake',
            'Princess Castle Cake',
            'Cars Theme Cake',
        ],
        'Wedding Cakes' => [
            'Elegant White Wedding Cake',
            'Rustic Naked Wedding Cake',
            'Floral Wedding Cake with Buttercream',
            'Gold Leaf Wedding Cake',
            'Ombre Rose Wedding Cake',
            'Geometric Wedding Cake',
            'Semi-Naked Wedding Cake with Berries',
            'Classic Tiered Wedding Cake',
        ],
        'Anniversary Cakes' => [
            'Heart Shaped Anniversary Cake',
            'Chocolate Mousse Anniversary Cake',
            'Photo Cake for Anniversary',
            'Red Roses Anniversary Cake',
            'Golden Anniversary Cake',
            'Personalized Message Cake',
            'Dual Flavour Anniversary Cake',
        ],
        'Cupcakes' => [
            'Vanilla Bean Cupcake',
            'Chocolate Ganache Cupcake',
            'Strawberry Swirl Cupcake',
            'Red Velvet Cupcake',
            'Lemon Meringue Cupcake',
            'Carrot Cake Cupcake',
            'Salted Caramel Cupcake',
            'Peanut Butter Cupcake',
            'Coconut Cream Cupcake',
            'Mint Chocolate Cupcake',
            'Cookies and Cream Cupcake',
            'Blueberry Cheesecake Cupcake',
            'Raspberry Rose Cupcake',
            'Pistachio Cupcake',
            'Matcha Green Tea Cupcake',
            'Chai Spice Cupcake',
            'Hazelnut Praline Cupcake',
            'Black Forest Cupcake',
            'Tiramisu Cupcake',
            'S\'mores Cupcake',
        ],
        'Pastries' => [
            'Fruit Danish Pastry',
            'Chocolate Croissant',
            'Almond Croissant',
            'Pain au Chocolat',
            'Apple Turnover',
            'Cream Horn',
            'Napoleon Slice',
            'Eclair',
            'Custard Puff',
            'Cinnamon Roll',
        ],
        'Cookies' => [
            'Chocolate Chip Cookie',
            'Oatmeal Raisin Cookie',
            'Peanut Butter Cookie',
            'Sugar Cookie',
            'Snickerdoodle',
            'Double Chocolate Cookie',
            'White Chocolate Macadamia Cookie',
            'Shortbread Cookie',
            'Gingerbread Cookie',
            'Molasses Cookie',
        ],
        'Custom Cakes' => [
            'Personalized Photo Cake',
            'Custom Shape Cake',
            'Theme Based Cake',
            'Logo Cake for Corporate',
            '3D Sculpted Cake',
            'Pull Me Up Cake',
            'Cake with Edible Image',
            'Surprise Inside Cake',
        ],
        'Seasonal Specials' => [
            'Christmas Yule Log',
            'Easter Bunny Cake',
            'Halloween Spiderweb Cake',
            'Thanksgiving Pumpkin Cake',
            'Valentine\'s Day Heart Cake',
            'Diwali Mithai Cake',
            'New Year Champagne Cake',
            'Summer Fruit Tart',
        ],
    ];

    protected $flavours = [
        'chocolate', 'vanilla', 'strawberry', 'red velvet', 'butterscotch',
        'pineapple', 'black forest', 'coffee', 'orange', 'lemon', 'carrot',
        'coconut', 'pistachio', 'hazelnut', 'tiramisu', 'mint', 'raspberry',
    ];

    public function run()
    {
        $faker = Faker::create();

        $categories = Category::all()->keyBy('name');

        foreach ($this->categoryNames as $catName => $productNames) {
            $category = $categories->get($catName);
            if (!$category) {
                $this->command->warn("Category '$catName' not found. Skipping.");
                continue;
            }

            $products = Product::where('category_id', $category->id)->get();
            $count = $products->count();

            if ($count == 0) {
                $this->command->warn("No products in category '$catName'. Skipping.");
                continue;
            }

            $this->command->info("Updating $count products in category '$catName'...");

            foreach ($products as $index => $product) {
                $nameIndex = $index % count($productNames);
                $newName = $productNames[$nameIndex];

                if (count($productNames) < $count) {
                    $suffix = floor($index / count($productNames)) + 1;
                    $newName .= " " . $this->numberToRoman($suffix);
                }

                $product->update([
                    'name' => $newName,
                    'slug' => Str::slug($newName . '-' . $product->id),
                    'description' => $faker->paragraph(),
                    'price' => $this->getPriceForCategory($catName, $faker),
                    'egg_type' => $faker->randomElement(['eggless', 'with_egg']),
                    'image' => 'https://picsum.photos/seed/' . $product->id . '/300/200',
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('All products updated successfully.');
    }

    private function getPriceForCategory($category, $faker)
    {
        $ranges = [
            'Birthday Cakes' => [500, 3000],
            'Wedding Cakes' => [5000, 15000],
            'Anniversary Cakes' => [800, 4000],
            'Cupcakes' => [50, 250],
            'Pastries' => [80, 300],
            'Cookies' => [30, 150],
            'Custom Cakes' => [1000, 8000],
            'Seasonal Specials' => [400, 2000],
        ];

        if (isset($ranges[$category])) {
            return $faker->randomFloat(2, $ranges[$category][0], $ranges[$category][1]);
        }

        return $faker->randomFloat(2, 100, 5000);
    }

    private function numberToRoman($num)
    {
        $map = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
        $result = '';
        while ($num > 0) {
            foreach ($map as $roman => $int) {
                if ($num >= $int) {
                    $num -= $int;
                    $result .= $roman;
                    break;
                }
            }
        }
        return $result;
    }
}