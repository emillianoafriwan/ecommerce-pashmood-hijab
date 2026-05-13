<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PashminaCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pashmina Voal',
            'Pashmina Ceruty',
            'Pashmina Silk',
        ];

        $categoryIds = collect($categories)->mapWithKeys(function ($name) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );

            return [$name => $category->id];
        });

        $catalog = [
            [
                'name' => 'Pashmina Voal Premium Dusty Rose',
                'category' => 'Pashmina Voal',
                'price' => 79000,
                'image_path' => 'images/pashmina-voal.svg',
                'description' => 'Pashmina voal premium dengan tekstur ringan, mudah dibentuk, dan warna dusty rose yang lembut untuk tampilan harian.',
                'variations' => [
                    ['color' => 'Dusty Rose', 'stock' => 24],
                    ['color' => 'Mauve', 'stock' => 18],
                ],
            ],
            [
                'name' => 'Pashmina Ceruty Babydoll Sage',
                'category' => 'Pashmina Ceruty',
                'price' => 69000,
                'image_path' => 'images/pashmina-ceruty.svg',
                'description' => 'Pashmina ceruty babydoll yang jatuh, flowy, dan nyaman untuk acara santai maupun semi-formal.',
                'variations' => [
                    ['color' => 'Sage', 'stock' => 20],
                    ['color' => 'Olive', 'stock' => 15],
                ],
            ],
            [
                'name' => 'Pashmina Silk Premium Champagne',
                'category' => 'Pashmina Silk',
                'price' => 89000,
                'image_path' => 'images/pashmina-silk.svg',
                'description' => 'Pashmina silk premium dengan tampilan mengilap elegan, cocok untuk acara spesial dan koleksi warna netral.',
                'variations' => [
                    ['color' => 'Champagne', 'stock' => 17],
                    ['color' => 'Latte', 'stock' => 14],
                ],
            ],
            [
                'name' => 'Pashmina Voal Premium White Gold',
                'category' => 'Pashmina Voal',
                'price' => 76000,
                'image_path' => 'images/pashmina-voal.svg',
                'description' => 'Pashmina voal warna white gold yang bersih dan elegan, mudah dipadukan dengan outfit polos maupun motif.',
                'variations' => [
                    ['color' => 'White Gold', 'stock' => 22],
                    ['color' => 'Ivory', 'stock' => 16],
                ],
            ],
            [
                'name' => 'Pashmina Silk Premium Black Gold',
                'category' => 'Pashmina Silk',
                'price' => 92000,
                'image_path' => 'images/pashmina-silk.svg',
                'description' => 'Pashmina silk black gold dengan kilau lembut dan bahan yang terasa mewah untuk tampilan formal.',
                'variations' => [
                    ['color' => 'Black Gold', 'stock' => 12],
                    ['color' => 'Espresso', 'stock' => 10],
                ],
            ],
        ];

        $products = Product::orderBy('id')->get();

        foreach ($products as $index => $product) {
            $item = $catalog[$index % count($catalog)];

            $product->update([
                'category_id' => $categoryIds[$item['category']],
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'description' => $item['description'],
                'price' => $item['price'],
                'stock' => collect($item['variations'])->sum('stock'),
                'image_path' => $item['image_path'],
            ]);

            $existingVariations = $product->variations()->orderBy('id')->get();

            if ($existingVariations->isEmpty()) {
                foreach ($item['variations'] as $variation) {
                    $product->variations()->create($variation);
                }

                continue;
            }

            foreach ($existingVariations as $variationIndex => $variation) {
                $variationData = $item['variations'][$variationIndex % count($item['variations'])];
                $variation->update($variationData);
            }
        }

        Category::whereIn('name', ['Sepatu Futsal', 'Sepatu Bola'])
            ->doesntHave('products')
            ->delete();
    }
}
