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
            'Pashmina Plisket',
            'Pashmina Viscose',
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
                'name' => 'Pashmina Voal Elegan Dusty Rose',
                'category' => 'Pashmina Voal',
                'price' => 79000,
                'image_path' => 'products/pashmina_voal_dusty_rose_new.png',
                'description' => 'Pashmina voal elegan dengan tekstur ringan, mudah dibentuk, dan warna dusty rose yang lembut untuk tampilan harian.',
                'variations' => [
                    ['color' => 'Dusty Rose'],
                    ['color' => 'Mauve'],
                ],
            ],
            [
                'name' => 'Pashmina Ceruty Premium Sage Green',
                'category' => 'Pashmina Ceruty',
                'price' => 69000,
                'image_path' => 'products/6Nw6am8IM2kTMeP9gEFfCgNw4yXAeXfPgvMKOeqB.jpg',
                'description' => 'Pashmina ceruty premium yang jatuh, flowy, dan nyaman untuk acara santai maupun semi-formal.',
                'variations' => [
                    ['color' => 'Sage Green'],
                    ['color' => 'Olive'],
                ],
            ],
            [
                'name' => 'Pashmina Silk Satin Champagne Gold',
                'category' => 'Pashmina Silk',
                'price' => 89000,
                'image_path' => 'products/dX5yRKVQ2LerEXkQwDgHxEWZVsT6qmHWPoGSnG6n.jpg',
                'description' => 'Pashmina silk satin dengan tampilan mengilap elegan, cocok untuk acara spesial dan koleksi warna netral.',
                'variations' => [
                    ['color' => 'Champagne Gold'],
                    ['color' => 'Latte'],
                ],
            ],
            [
                'name' => 'Pashmina Voal Sheer Ivory White',
                'category' => 'Pashmina Voal',
                'price' => 76000,
                'image_path' => 'products/h5IvvNov5TQv4IBIr4LSppUv3t9zVeENfU1yc2zk.jpg',
                'description' => 'Pashmina voal sheer warna ivory white yang bersih dan elegan, mudah dipadukan dengan outfit polos maupun motif.',
                'variations' => [
                    ['color' => 'Ivory White'],
                    ['color' => 'Cream'],
                ],
            ],
            [
                'name' => 'Pashmina Silk Mewah Espresso Black',
                'category' => 'Pashmina Silk',
                'price' => 92000,
                'image_path' => 'products/bnFgGQlI8R7YDOwmOqGSr8DtOVzAECqTm6EEHZ0I.jpg',
                'description' => 'Pashmina silk mewah warna espresso black dengan kilau lembut dan bahan yang terasa premium untuk tampilan formal.',
                'variations' => [
                    ['color' => 'Espresso Black'],
                    ['color' => 'Charcoal'],
                ],
            ],
            [
                'name' => 'Pashmina Ceruty Babydoll Rose Ballet',
                'category' => 'Pashmina Ceruty',
                'price' => 69000,
                'image_path' => 'products/pashmina_rose_ballet.png',
                'description' => 'Pashmina ceruty babydoll berkualitas tinggi dengan warna rose ballet yang manis dan feminim, sangat jatuh dan mudah dibentuk.',
                'variations' => [
                    ['color' => 'Rose Ballet'],
                    ['color' => 'Soft Pink'],
                ],
            ],
            [
                'name' => 'Pashmina Plisket Ceruty Mocca',
                'category' => 'Pashmina Plisket',
                'price' => 75000,
                'image_path' => 'products/pashmina_mocca_plisket.png',
                'description' => 'Pashmina plisket ceruty babydoll dengan lipatan plisket rapi tanpa garis tengah, warna mocca netral yang mewah dan elegan.',
                'variations' => [
                    ['color' => 'Mocca'],
                    ['color' => 'Hazelnut'],
                ],
            ],
            [
                'name' => 'Pashmina Voal Premium Navy Blue',
                'category' => 'Pashmina Voal',
                'price' => 79000,
                'image_path' => 'products/pashmina_navy_voal.png',
                'description' => 'Pashmina voal premium warna navy blue yang deep dan solid. Bahan adem, tegak di dahi, dan tidak kedap di telinga.',
                'variations' => [
                    ['color' => 'Navy Blue'],
                    ['color' => 'Denim'],
                ],
            ],
            [
                'name' => 'Pashmina Silk Premium Emerald',
                'category' => 'Pashmina Silk',
                'price' => 95000,
                'image_path' => 'products/pashmina_silk_emerald.png',
                'description' => 'Pashmina silk premium warna emerald green yang menawan, berkilau lembut dengan bahan mewah. Cocok untuk acara formal dan semi-formal.',
                'variations' => [
                    ['color' => 'Emerald Green'],
                    ['color' => 'Forest Green'],
                ],
            ],
            [
                'name' => 'Pashmina Ceruty Babydoll Terracotta',
                'category' => 'Pashmina Ceruty',
                'price' => 72000,
                'image_path' => 'products/pashmina_ceruty_terracotta.png',
                'description' => 'Pashmina ceruty babydoll warna terracotta yang hangat dan earthy. Jatuh sempurna, flowy, dan cocok untuk tampilan harian maupun casual.',
                'variations' => [
                    ['color' => 'Terracotta'],
                    ['color' => 'Burnt Orange'],
                ],
            ],
            [
                'name' => 'Pashmina Plisket Premium Lavender',
                'category' => 'Pashmina Plisket',
                'price' => 78000,
                'image_path' => 'products/pashmina_plisket_lavender.png',
                'description' => 'Pashmina plisket premium warna lavender yang anggun dan feminin. Lipatan plisket halus dan rapi, tahan lama tanpa perlu disetrika.',
                'variations' => [
                    ['color' => 'Lavender'],
                    ['color' => 'Lilac'],
                ],
            ],
            [
                'name' => 'Pashmina Voal Premium Caramel',
                'category' => 'Pashmina Voal',
                'price' => 79000,
                'image_path' => 'products/pashmina_voal_caramel.png',
                'description' => 'Pashmina voal premium warna caramel yang hangat dan netral, mudah dipadukan dengan berbagai outfit. Bahan ringan dan nyaman sepanjang hari.',
                'variations' => [
                    ['color' => 'Caramel'],
                    ['color' => 'Toffee'],
                ],
            ],
            [
                'name' => 'Pashmina Viscose Bamboo Mint',
                'category' => 'Pashmina Viscose',
                'price' => 62000,
                'image_path' => 'products/pashmina_viscose_mint.png',
                'description' => 'Pashmina viscose bamboo warna mint segar yang adem dan breathable. Cocok untuk cuaca panas, bahan lembut dan ramah kulit sensitif.',
                'variations' => [
                    ['color' => 'Mint'],
                    ['color' => 'Sage Green'],
                ],
            ],
        ];

        $products = Product::orderBy('id')->get();

        foreach ($products as $index => $product) {
            $item = $catalog[$index % count($catalog)];

            // Jangan timpa gambar jika produk sudah punya gambar upload di storage
            $keepExistingImage = $product->image_path
                && !str_starts_with($product->image_path, 'images/');

            $updateData = [
                'category_id' => $categoryIds[$item['category']],
                'name'        => $item['name'],
                'slug'        => Str::slug($item['name']),
                'description' => $item['description'],
                'price'       => $item['price'],
            ];

            if (!$keepExistingImage) {
                $updateData['image_path'] = $item['image_path'];
            }

            $product->update($updateData);

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
