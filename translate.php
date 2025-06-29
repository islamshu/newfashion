<?php
require __DIR__.'/vendor/autoload.php';
use Stichoza\GoogleTranslate\GoogleTranslate;

function translate_laravel_lang_file() {
    // تهيئة المسارات
    $basePath = __DIR__; // مسار المشروع
    $inputFile = $basePath . '/lang/ar.json';
    $backupFile = $basePath . '/lang/he_backup.json';
    
    // إنشاء نسخة احتياطية
    if (!copy($inputFile, $backupFile)) {
        die("فشل في إنشاء نسخة احتياطية");
    }
    
    // تهيئة المترجم
    $tr = new GoogleTranslate('he'); // الهدف: العبرية
    
    // تحميل ملف JSON
    $jsonString = file_get_contents($inputFile);
    $data = json_decode($jsonString, true);
    
    if ($data === null) {
        die("خطأ في قراءة ملف JSON");
    }
    
    // ترجمة القيم
    $translatedData = [];
    $totalItems = count($data);
    $current = 0;
    
    foreach ($data as $key => $value) {
        $current++;
        echo "جاري معالجة العنصر $current من $totalItems...\n";
        
        if (is_string($value)) {
            // تحقق إذا كانت القيمة تحتوي على أحرف عربية
            if (preg_match('/[\x{0600}-\x{06FF}]/u', $value)) {
                try {
                    $translatedValue = $tr->setSource('ar')->translate($value);
                    $translatedData[$key] = $translatedValue;
                    echo "تم ترجمة: '$value' => '$translatedValue'\n";
                    
                    // تأخير لتجنب حظر IP
                    usleep(500000); // 0.5 ثانية
                } catch (Exception $e) {
                    echo "⚠️ خطأ في ترجمة '$value': " . $e->getMessage() . "\n";
                    $translatedData[$key] = $value;
                }
            } else {
                $translatedData[$key] = $value;
            }
        } else {
            $translatedData[$key] = $value;
        }
    }
    
    // حفظ الملف المترجم
    file_put_contents($inputFile, json_encode($translatedData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "✅ تم تحديث ملف الترجمة بنجاح: $inputFile\n";
    echo "📦 تم إنشاء نسخة احتياطية في: $backupFile\n";
}

// تشغيل الترجمة
translate_laravel_lang_file();
?>