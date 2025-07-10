<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductThumbnail;
use App\Models\ProductVariation;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    // صور لكل فئة حسب الـ slug
    protected $categoryImages = [
        'mlabs-2VTaF' => [ // ملابس
            'https://images.unsplash.com/photo-1551232864-3f0890e580d9',
            'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f',
            'https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9'
        ],
        'ahthy-6YMih' => [ // أحذية
            'https://images.unsplash.com/photo-1560769629-975ec94e6a86',
            'https://images.unsplash.com/photo-1543163521-1bf539c55dd2',
            'https://images.unsplash.com/photo-1460353581641-37baddab0fa2'
        ],
        'shnt-nyAk9' => [ // شنط
            'https://images.unsplash.com/photo-1590874103328-eac38a683ce7',
            'https://images.unsplash.com/photo-1566150902887-9679ecc155ba',
            'https://images.unsplash.com/photo-1591348122449-02525d70379b'
        ],
        'akssoarat-vo1H8' => [ // عطور
            'https://images.unsplash.com/photo-1595425964079-6b46a58faca1',
            'https://images.unsplash.com/photo-1615368144592-6a8a0a705a1e',
            'https://images.unsplash.com/photo-1594035910387-fea47794261f'
        ],
        'mkyag-QjJUZ' => [ // مكياج
            'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9',
            'https://images.unsplash.com/photo-1596462502278-27bfdc403348',
            'https://images.unsplash.com/photo-1625772452859-1c03d5bf1137'
        ]
    ];

    public function run()
    {
        $faker = Faker::create();

        // الحصول على الفئات النشطة فقط
        $categories = Category::where('status', 1)->get();

        if ($categories->isEmpty()) {
            $this->command->error('لا توجد فئات متاحة! يرجى إنشاء الفئات أولاً.');
            return;
        }

        // تنظيف المجلدات القديمة
        $this->cleanDirectories();

        $this->command->info('بدء إنشاء المنتجات...');

        $bar = $this->command->getOutput()->createProgressBar(50);
        $bar->start();

        for ($i = 1; $i <= 10; $i++) {
            try {
                $category = $categories->random();
                $this->createProduct($faker, $category, $i);
                $bar->advance();
            } catch (\Exception $e) {
                $this->command->error("\nخطأ في إنشاء المنتج {$i}: " . $e->getMessage());
                continue;
            }
        }

        $bar->finish();
        $this->command->info("\nتم إنشاء 50 منتج بنجاح!");
    }

    protected function cleanDirectories()
    {
        Storage::deleteDirectory('public/products/thumbnails');
        Storage::deleteDirectory('public/products/images');
        Storage::makeDirectory('public/products/thumbnails');
        Storage::makeDirectory('public/products/images');
    }

    protected function createProduct($faker, $category, $index)
    {
        // معالجة الترجمات بشكل آمن
        $nameTranslations = $this->getSafeTranslations($category->name, [
            'ar' => 'منتج',
            'he' => 'מוצר'
        ]);

        $product = new Product();

        // تعيين البيانات الأساسية
        $product->setTranslations('name', [
            'ar' => $nameTranslations['ar'] . ' ' . $faker->word . ' ' . $index,
            'he' => $nameTranslations['he'] . ' ' . $faker->word . ' ' . $index,
        ]);

        $product->setTranslations('description', [
            'ar' => $this->generateArabicDescription($category, $nameTranslations['ar']),
            'he' => $this->generateHebrewDescription($category, $nameTranslations['he']),
        ]);

        $product->setTranslations('short_description', [
            'ar' => $this->generateArabicShortDesc($nameTranslations['ar']),
            'he' => $this->generateHebrewShortDesc($nameTranslations['he']),
        ]);

        // تعيين الخصائص
        $price = $faker->numberBetween(50, 1000);
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

        // إنشاء الصور
        $this->createProductImages($product, $category);

        // إنشاء المتغيرات
        $this->createProductVariations($product, $category, $price, $faker);
    }

    protected function getSafeTranslations($jsonString, $defaults)
    {
        $decoded = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return $defaults;
        }

        return [
            'ar' => $decoded['ar'] ?? $defaults['ar'],
            'he' => $decoded['he'] ?? $defaults['he']
        ];
    }

    protected function createProductImages($product, $category)
    {
        $categorySlug = $category->slug;
        $imageUrls = $this->categoryImages[$categorySlug] ?? $this->categoryImages['mkyag-QjJUZ'];

        // إنشاء الصور المصغرة (1-3 صور)
        $thumbnailCount = rand(1, 3);
        for ($t = 0; $t < $thumbnailCount; $t++) {
            $this->downloadAndSaveImage(
                $imageUrls[$t % count($imageUrls)],
                $product->id,
                'thumbnails',
                $t,
                $t === 0 ? $product : null
            );
        }

        // إنشاء صور إضافية (0-3 صور)
        $imageCount = rand(0, 3);
        for ($img = 0; $img < $imageCount; $img++) {
            $this->downloadAndSaveImage(
                $imageUrls[$img % count($imageUrls)],
                $product->id,
                'images',
                $img
            );
        }
    }



protected function downloadAndSaveImage($url, $productId, $type, $index, $product = null)
{
    try {
        $response = Http::get($url . '?random=' . Str::random(10));

        if ($response->successful()) {
            $filename = "product_{$productId}_{$type}_{$index}.jpg";
            $path = "products/{$type}/{$filename}";

            // Store image in 'public' disk
            Storage::disk('public')->put($path, $response->body());

            if ($type === 'thumbnails') {
                if ($index === 0 && $product) {
                    $product->image = $path; // this is 'products/thumbnails/xxx.jpg'
                    $product->save();
                }

                ProductThumbnail::create([
                    'product_id' => $productId,
                    'image' => $path,
                ]);
            } else {
                ProductImage::create([
                    'product_id' => $productId,
                    'image' => $path,
                ]);
            }
        } else {
            $this->command->error("فشل تحميل الصورة من الرابط: {$url}");
        }
    } catch (\Exception $e) {
        $this->command->error("خطأ في تحميل الصورة: {$url} - " . $e->getMessage());
    }
}


    protected function createProductVariations($product, $category, $basePrice, $faker)
    {
        $variationCount = rand(1, 3);
        $colors = $this->getColorsForCategory($category->slug);

        for ($v = 0; $v < $variationCount; $v++) {
            $colorIndex = $v % count($colors['ar']);

            ProductVariation::create([
                'product_id' => $product->id,
                'color_id' => Arr::random([8, 9, 11, 13]),
                'size_id' => Arr::random([10, 12]),
                'stock' => rand(0, 100),
                // لا نضع price هنا
            ]);
        }
    }

    protected function generateArabicDescription($category, $categoryName)
    {
        $descriptions = [
            "{$categoryName} عالي الجودة مصمم ليوفر لك أفضل تجربة استخدام.",
            "تم تصنيع هذا {$categoryName} من أفضل المواد الخام لضمان المتانة والراحة.",
            "{$categoryName} أنيق وعصري يناسب جميع المناسبات والأذواق.",
            "تميز بأسلوبك مع هذا {$categoryName} الفاخر المصمم بعناية.",
            "{$categoryName} عملي وأنيق، يجمع بين الجمال والوظائف العملية."
        ];

        return $descriptions[array_rand($descriptions)];
    }

    protected function generateHebrewDescription($category, $categoryName)
    {
        $descriptions = [
            "{$categoryName} באיכות גבוהה שנועד לספק לך את חוויית השימוש הטובה ביותר.",
            "ה-{$categoryName} הזה מיוצר מחומרי הגלם הטובים ביותר כדי להבטיח עמידות ונוחות.",
            "{$categoryName} אלגנטי ומודרני המתאים לכל האירועים והטעמים.",
            "התבלטי עם הסגנון שלך עם ה-{$categoryName} המפואר הזה המעוצב בקפידה.",
            "{$categoryName} פרקטי ואלגנטי, משלב בין יופי לפונקציונליות מעשית."
        ];

        return $descriptions[array_rand($descriptions)];
    }

    protected function generateArabicShortDesc($categoryName)
    {
        return "{$categoryName} مميز بجودة عالية وتصميم أنيق";
    }

    protected function generateHebrewShortDesc($categoryName)
    {
        return "{$categoryName} ייחודי באיכות גבוהה ועיצוב אלגנטי";
    }

    protected function getColorsForCategory($categorySlug)
    {
        if (in_array($categorySlug, ['mlabs-2VTaF', 'ahthy-6YMih'])) {
            return [
                'ar' => ['أسود', 'أبيض', 'أزرق', 'رمادي', 'بني'],
                'he' => ['שחור', 'לבן', 'כחול', 'אפור', 'חום']
            ];
        } elseif ($categorySlug === 'mkyag-QjJUZ') {
            return [
                'ar' => ['وردي', 'نبيتي', 'برونزي', 'ذهبي', 'طبيعي'],
                'he' => ['ורוד', 'בורדו', 'ארד', 'זהב', 'טבעי']
            ];
        } else {
            return [
                'ar' => ['أحمر', 'أخضر', 'أصفر', 'فضي', 'ذهبي'],
                'he' => ['אדום', 'ירוק', 'צהוב', 'כסף', 'זהב']
            ];
        }
    }

    protected function getSizeForCategory($categorySlug)
    {
        if (in_array($categorySlug, ['mlabs-2VTaF', 'ahthy-6YMih'])) {
            return ['S', 'M', 'L', 'XL'][rand(0, 3)];
        } elseif ($categorySlug === 'shnt-nyAk9') {
            return ['صغير', 'متوسط', 'كبير'][rand(0, 2)];
        } else {
            return 'واحد';
        }
    }
}
