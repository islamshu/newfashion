<?php

function extractTranslations($path, &$translations = [])
{
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

    foreach ($files as $file) {
        if (!$file->isFile()) continue;

        $content = file_get_contents($file->getRealPath());

        // Match all __('...') patterns
        if (preg_match_all("/__\(\s*['\"](.*?)['\"]\s*\)/u", $content, $matches)) {
            foreach ($matches[1] as $text) {
                $translations[$text] = $text;
            }
        }
    }
}

// 1. Init translations array
$allTranslations = [];

// 2. Scan resources (Blade templates)
extractTranslations(__DIR__ . '/resources', $allTranslations);

// 3. Scan controllers
extractTranslations(__DIR__ . '/app/Http/Controllers', $allTranslations);

// 4. Save to JSON
file_put_contents(__DIR__ . '/translations.json', json_encode($allTranslations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "تم استخراج " . count($allTranslations) . " ترجمة إلى translations.json\n";
