<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductThumbnail;
use App\Models\ProductVariation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // تأكد من وجود مجلد الصور
        Storage::makeDirectory('public/products/thumbnails');
        Storage::makeDirectory('public/products/images');

        $categories = Category::where('status', 1)->get();

        if ($categories->count() === 0) {
            $this->command->warn('No active categories found. Seeder stopped.');
            return;
        }

        // Map عربي -> كلمة مفتاحية للصور
        $keywordMap = [
            'ملابس' => 'clothes',
            'أحذية' => 'shoes',
            'شنط'   => 'bags',
            'عطور'  => 'perfume',
            'مكياج' => 'makeup',
        ];

        for ($i = 1; $i <= 10; $i++) {
            $category = $categories->random();
            $categoryName = json_decode($category->name)->ar ?? 'منتج';

            $product = new Product();

            $product->setTranslations('name', [
                'ar' => 'منتج ' . $faker->word . ' ' . $i,
                'he' => 'מוצר ' . $faker->word . ' ' . $i,
            ]);

            $product->setTranslations('description', [
                'ar' => $faker->paragraph(3),
                'he' => $faker->paragraph(3),
            ]);

            $product->setTranslations('short_description', [
                'ar' => $faker->sentence,
                'he' => $faker->sentence,
            ]);

            $price = $faker->numberBetween(100, 1000);
            $discount = $faker->boolean(30) ? $faker->numberBetween(5, 50) : 0;

            $product->price = $price;
            $product->discount_price = $discount > 0 ? $price * (1 - ($discount / 100)) : null;
            $product->discount_start = $discount > 0 ? now() : null;
            $product->discount_end = $discount > 0 ? now()->addDays($faker->numberBetween(7, 30)) : null;
            $product->sku = strtoupper(Str::random(10));
            $product->category_id = $category->id;
            $product->is_featured = $faker->boolean(20);
            $product->status = true;
            $product->save();

            // ❗️صورة Unsplash حسب نوع الكاتيجوري
            $keyword = $keywordMap[$categoryName] ?? 'product';
            $seed = $keyword . $product->id;
            $imageUrl = "https://picsum.photos/seed/{$seed}/600/600";
            // ⬇️ حفظ الصورة كـ thumbnail وصورة رئيسية
            $thumbFilename = 'product_' . $product->id . '_thumb_0.jpg';
            $savePath = 'public/products/thumbnails/' . $thumbFilename;

            $this->downloadImageFromUrl($imageUrl, $savePath);

            // تعيينها كصورة رئيسية
            $product->image = 'products/thumbnails/' . $thumbFilename;
            $product->save();

            // حفظها في جدول الـ thumbnails
            ProductThumbnail::create([
                'product_id' => $product->id,
                'image' => 'products/thumbnails/' . $thumbFilename,
            ]);

            // صور إضافية
            $imageCount = $faker->numberBetween(1, 3);
            for ($img = 0; $img < $imageCount; $img++) {
                $imgFilename = 'product_' . $product->id . '_img_' . $img . '.jpg';
                $imgPath = 'public/products/images/' . $imgFilename;
                $this->downloadImageFromUrl("https://picsum.photos/600x600/?{$keyword}", $imgPath);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'products/images/' . $imgFilename,
                ]);
            }

            // Variations
            $variationCount = $faker->numberBetween(1, 4);
            for ($v = 0; $v < $variationCount; $v++) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'color_id' => $faker->randomElement(['8', '9', '11', '33']),
                    'size_id' => $faker->randomElement(['10', '12']),
                    'stock' => $faker->numberBetween(0, 100),
                ]);
            }

            if ($i % 10 === 0) {
                $this->command->info("✅ Created {$i} products...");
            }
        }

        $this->command->info('🎉 Done: 10 products created with real images!');
    }

    private function downloadImageFromUrl($url, $savePath)
{
    try {
        $contents = file_get_contents($url);
        if ($contents) {
            Storage::put($savePath, $contents);
            return true;
        }
    } catch (\Exception $e) {
        $this->command->warn("⚠️ فشل تحميل الصورة من: $url");
    }

    return false;
}

}
