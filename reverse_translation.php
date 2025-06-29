<?php

$path = base_path('lang/he.json'); // ← Laravel-style path

if (!file_exists($path)) {
    exit("❌ الملف غير موجود: $path\n");
}

$json = file_get_contents($path);
$data = json_decode($json, true);

if (!$data) {
    exit("❌ فشل في قراءة JSON أو الملف فارغ.\n");
}

// عكس المفاتيح والقيم
$reversed = [];
foreach ($data as $key => $value) {
    if (trim($value) !== '') {
        $reversed[$value] = $key;
    }
}

// حفظ الملف الجديد داخل lang/
$reversedPath = base_path('lang/reversed_he.json');
file_put_contents($reversedPath, json_encode($reversed, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "✅ تم إنشاء الملف المعكوس: lang/reversed_he.json\n";
