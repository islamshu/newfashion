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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OnlineCreateFakeProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $faker = Faker::create();
        $categories = Category::all();

        // ربط slug التصنيف مع مجلد الصور
        $categoryMap = [
            'mlabs-LMQGC' => 'cloth',
            'ahthy-VIMrw' => 'shose',
            'shnt-3ThGm'  => 'bags',
            'mkyag-BzgXX' => 'makeup'
        ];

        // تصنيفات لا تحتوي على ألوان أو مقاسات
        $noVariationCategories = ['mkyag-BzgXX'];

        $colors = ProductAttribute::where('type', 'color')->pluck('id')->toArray();
        $sizes = ProductAttribute::where('type', 'size')->pluck('id')->toArray();

        // قوائم كلمات عربية وعبرية لأسماء المنتجات
        $arabicWords = ['جميل', 'راقي', 'حديث', 'مميز', 'فاخر', 'حصري', 'عصري', 'متين', 'مريح', 'قوي'];
        $hebrewWords = ['יפה', 'אלגנטי', 'מודרני', 'מיוחד', 'יוקרתי', 'בלעדי', 'נוח', 'חזק', 'מושלם', 'חדשני'];

        // أوصاف عبرية جاهزة
        $hebrewDescriptions = [
            'זהו מוצר איכותי ומודרני המתאים לכל משתמש.',
            'מוצר זה מיוצר מחומרים עמידים ואמינים.',
            'המוצר מציע עיצוב אלגנטי ונוחות מירבית.',
            'מוצר זה מיועד לשימוש יומיומי ומספק ביצועים מצוינים.',
            'מוצר בעיצוב חדשני המשלב איכות ונוחות.',
        ];

        for ($i = 0; $i < 50; $i++) {
            $category = $categories->random();
            $folder = $categoryMap[$category->slug] ?? 'makeup';
            $images = $this->getLocalCategoryImages($folder);

            if ($images->count() < 6) {
                \Log::warning("Not enough images in folder: {$folder}");
                continue;
            }

            // توليد أسماء طبيعية بالعربي والعبري
            $productNameAr = 'منتج ' . $faker->randomElement($arabicWords);
            $productNameHe = 'מוצר ' . $faker->randomElement($hebrewWords);

            // توليد وصف عربي وعبرى (باستخدام faker والعبرى من القائمة)
            $descAr = $faker->realText(200, 2);
            $descHe = $faker->randomElement($hebrewDescriptions);

            $shortDescAr = $faker->sentence(8);
            $shortDescHe = $faker->sentence(8);

            // دمج الوصفين لصنع الوسوم tags (كلمات مفصولة بفواصل)
            $combinedDesc = $descAr . ' ' . $descHe;
            $tags = implode(',', preg_split('/\s+/', $combinedDesc));

            // نسخ الصورة الرئيسية
            $mainImageFile = $images[0];
            $mainImageName = basename($mainImageFile);
            $mainImagePath = "products/{$folder}/{$mainImageName}";
            Storage::disk('public')->put($mainImagePath, file_get_contents($mainImageFile));

            // إنشاء المنتج
            $product = Product::create([
                'name' => [
                    'ar' => $productNameAr,
                    'he' => $productNameHe,
                ],
                'description' => [
                    'ar' => $descAr,
                    'he' => $descHe,
                ],
                'short_description' => [
                    'ar' => $shortDescAr,
                    'he' => $shortDescHe,
                ],
                'price' => $faker->randomFloat(2, 20, 200),
                'discount_price' => null,
                'discount_start' => null,
                'discount_end' => null,
                'sku' => strtoupper(Str::random(8)),
                'image' => $mainImagePath,
                'category_id' => $category->id,
                'is_featured' => rand(0, 1),
                'status' => true,
                'tags' => $tags,
                'fake_rating_enabled' => false,
                'fake_rating_value' => 0,
            ]);

            // صور Thumbnails (نسخ وتخزين)
            for ($j = 1; $j <= 2; $j++) {
                $file = $images[$j];
                $fileName = basename($file);
                $thumbPath = "products/{$folder}/{$fileName}";
                Storage::disk('public')->put($thumbPath, file_get_contents($file));

                ProductThumbnail::create([
                    'product_id' => $product->id,
                    'image' => $thumbPath,
                ]);
            }

            // صور إضافية (نسخ وتخزين)
            for ($j = 3; $j <= 5; $j++) {
                $file = $images[$j];
                $fileName = basename($file);
                $extraPath = "products/{$folder}/{$fileName}";
                Storage::disk('public')->put($extraPath, file_get_contents($file));

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $extraPath,
                ]);
            }

            // المتغيرات (Variation)
            if (in_array($category->slug, $noVariationCategories)) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'color_id' => null,
                    'size_id' => null,
                    'stock' => rand(5, 20),
                ]);
            } else {
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
     * جلب صور الفئة من مجلد الصور داخل public/front/products/{folder}
     */
    protected function getLocalCategoryImages($folder)
    {
        $path = public_path("front/products/{$folder}");

        if (!is_dir($path)) {
            \Log::error("Folder not found: {$path}");
            return collect();
        }

        $files = glob($path . '/*.{jpg,jpeg,png}', GLOB_BRACE);
        return collect($files)->shuffle()->values();
    }
}