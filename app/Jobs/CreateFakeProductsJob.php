<?php

namespace App\Jobs;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductThumbnail;
use App\Models\ProductVariation;
use App\Models\Category;
use App\Models\ProductAttribute;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class CreateFakeProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $faker = Faker::create();
        $categories = Category::all();

        $categoryImages = [
            'mlabs-2VTaF' => [ // ملابس
                'https://images.unsplash.com/photo-1551232864-3f0890e580d9',
                'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f',
                'https://images.unsplash.com/photo-1491553895911-0055eca6402d',
                'https://images.unsplash.com/photo-1495020689067-958852a7765e',
                'https://images.unsplash.com/photo-1520974722076-29a33c542ef6',
            ],
            'ahthy-6YMih' => [ // أحذية
                'https://images.unsplash.com/photo-1588361861953-1237fd7cf013',
                'https://images.unsplash.com/photo-1541099649105-f69ad21f3246',
                'https://images.unsplash.com/photo-1600185365092-d8f67d205314',
                'https://images.unsplash.com/photo-1618354691373-25e40b1e9d46',
                'https://images.unsplash.com/photo-1618354691305-dfb330a6fa53',
            ],
            'shnt-nyAk9' => [ // شنط
                'https://images.unsplash.com/photo-1610426662143-40a1d0efba88',
                'https://images.unsplash.com/photo-1598032891449-dfbdc94891d0',
                'https://images.unsplash.com/photo-1627647229840-d3e47f63d469',
                'https://images.unsplash.com/photo-1589571894960-20bbe2828a27',
                'https://images.unsplash.com/photo-1600180758890-eac7e4bcf7cc',
            ],
            'akssoarat-vo1H8' => [ // عطور
                'https://images.unsplash.com/photo-1600185365092-d8f67d205314',
                'https://images.unsplash.com/photo-1615673037358-17dbef34b042',
                'https://images.unsplash.com/photo-1618354691305-dfb330a6fa53',
                'https://images.unsplash.com/photo-1618375788134-63f3fae2c6f6',
                'https://images.unsplash.com/photo-1600180758890-eac7e4bcf7cc',
            ],
            'mkyag-QjJUZ' => [ // مكياج
                'https://images.unsplash.com/photo-1626421934242-2d2b5e4c41f4',
                'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9',
                'https://images.unsplash.com/photo-1626421935177-c96fc73f0244',
                'https://images.unsplash.com/photo-1588167100384-e63c1f489b48',
                'https://images.unsplash.com/photo-1580480055273-228ff5388ef8',
            ],
        ];

        $colors = ProductAttribute::where('type', 'color')->pluck('id')->toArray();
        $sizes = ProductAttribute::where('type', 'size')->pluck('id')->toArray();

        for ($i = 0; $i < 1; $i++) {
            $category = $categories->random();
            $images = $categoryImages[$category->slug] ?? $categoryImages['mkyag-QjJUZ'];
            shuffle($images);

            $product = Product::create([
                'name' => [
                    'ar' => 'منتج ' . $faker->word,
                    'he' => 'מוצר ' . $faker->word,
                ],
                'description' => [
                    'ar' => $faker->paragraph,
                    'he' => $faker->paragraph,
                ],
                'short_description' => [
                    'ar' => $faker->sentence,
                    'he' => $faker->sentence,
                ],
                'price' => $faker->randomFloat(2, 20, 200),

                'sku' => strtoupper(Str::random(8)),
                'image' => $this->storeImageFromUrl($images[0]),
                'category_id' => $category->id,
                'is_featured' => rand(0, 1),
                'status' => true,
            ]);

            // Thumbnails
            for ($j = 1; $j <= 2; $j++) {
                $thumb = $this->storeImageFromUrl($images[$j] ?? $images[0]);
                if ($thumb) {
                    ProductThumbnail::create([
                        'product_id' => $product->id,
                        'image' => $thumb,
                    ]);
                }
            }
            // Images
            for ($j = 3; $j <= 5; $j++) {
                $img = $this->storeImageFromUrl($images[$j] ?? $images[0]);
                if ($img) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $img,
                    ]);
                }
            }

            // Variations
            $usedCombinations = [];
            for ($v = 0; $v < 3; $v++) {
                $color = $faker->randomElement($colors);
                $size = $faker->randomElement($sizes);

                // Avoid duplicate combinations
                $comboKey = $color . '_' . $size;
                if (in_array($comboKey, $usedCombinations)) {
                    continue;
                }
                $usedCombinations[] = $comboKey;

                ProductVariation::create([
                    'product_id' => $product->id,
                    'color_id' => $color,
                    'size_id' => $size,
                    'stock' => rand(1, 20),
                ]);
            }
        }
    }
    protected function storeImageFromUrl($url, $folder = 'products')
{
    try {
        $response = Http::timeout(60)->get($url); // ⬅️ زيادة المهلة
        if ($response->successful()) {
            $extension = 'jpg';
            $filename = $folder . '/' . uniqid() . '.' . $extension;
            Storage::disk('public')->put($filename, $response->body());
            return $filename;
        } else {
            logger()->error("Image request failed. Status: " . $response->status());
        }
    } catch (\Exception $e) {
        logger()->error('Image Download Failed: ' . $e->getMessage());
    }

    return null;
}

}
