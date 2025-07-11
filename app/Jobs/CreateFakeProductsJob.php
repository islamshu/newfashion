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

class CreateFakeProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $faker = Faker::create();
        $categories = Category::all();

        // ربط slug التصنيف مع مجلد الصور
        $categoryMap = [
            'mlabs-2VTaF'     => 'cloth',
            'ahthy-6YMih'     => 'shose',
            'shnt-nyAk9'      => 'bags',
            'akssoarat-vo1H8' => 'perfumes',
            'mkyag-QjJUZ'     => 'makeup',
        ];

        // تصنيفات لا تحتوي على ألوان أو مقاسات
        $noVariationCategories = ['akssoarat-vo1H8', 'mkyag-QjJUZ'];

        $colors = ProductAttribute::where('type', 'color')->pluck('id')->toArray();
        $sizes = ProductAttribute::where('type', 'size')->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            $category = $categories->random();
            $folder = $categoryMap[$category->slug] ?? 'makeup';
            $images = $this->getLocalCategoryImages($folder);

            if ($images->count() < 6) {
                \Log::warning("Not enough images in folder: {$folder}");
                continue;
            }

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
                'image' => 'products/' . $folder . '/' . basename($images[0]),
                'category_id' => $category->id,
                'is_featured' => rand(0, 1),
                'status' => true,
            ]);

            // صور Thumbnails
            for ($j = 1; $j <= 2; $j++) {
                ProductThumbnail::create([
                    'product_id' => $product->id,
                    'image' => 'products/' . $folder . '/' . basename($images[$j]),
                ]);
            }

            // صور إضافية
            for ($j = 3; $j <= 5; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'products/' . $folder . '/' . basename($images[$j]),
                ]);
            }

            // المتغيرات (Variation)
            if (in_array($category->slug, $noVariationCategories)) {
                // منتجات لا تحتوي على color/size
                ProductVariation::create([
                    'product_id' => $product->id,
                    'color_id' => null,
                    'size_id' => null,
                    'stock' => rand(5, 20),
                ]);
            } else {
                // منتجات بألوان ومقاسات
                $usedCombinations = [];
                for ($v = 0; $v < 3; $v++) {
                    $color = $faker->randomElement($colors);
                    $size = $faker->randomElement($sizes);
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
    }

    /**
     * جلب صور الفئة من مجلد الصور المحلي داخل public/storage/products/{folder}
     */
    protected function getLocalCategoryImages($folder)
    {
        $path = public_path("storage/products/{$folder}");

        if (!is_dir($path)) {
            \Log::error("Folder not found: {$path}");
            return collect();
        }

        $files = glob($path . '/*.jpeg');
        return collect($files)->shuffle()->values();
    }
}
