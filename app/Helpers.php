<?php

use App\Models\GeneralInfo;
use Illuminate\Support\Facades\File;
use ColorThief\ColorThief;
use League\ColorExtractor\Palette;
use League\ColorExtractor\Color;

if (!function_exists('get_general_value')) {

    function get_general_value($key)
    {
        $general = GeneralInfo::where('key', $key)->first();
        if ($general) {
            return $general->value;
        }

        return '';
    }
}
if (!function_exists('openJSONFile')) {

    function openJSONFile($code)
    {
        $jsonString = [];
        if (File::exists(base_path('lang/' . $code . '.json'))) {
            $jsonString = file_get_contents(base_path('lang/' . $code . '.json'));
            $jsonString = json_decode($jsonString, true);
        }
        return $jsonString;
    }
}
if (!function_exists('saveJSONFile')) {

    function saveJSONFile($code, $data)
    {
        ksort($data);
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents(base_path('lang/' . $code . '.json'), stripslashes($jsonData));
    }
}
if (!function_exists('getColor')) {
    function getColor($category)
    {
        $relativePath = str_replace('storage/', '', $category->image);
        $localPath = storage_path('app/public/' . $relativePath);

        if (!file_exists($localPath)) {
            return '#cccccc'; // لون افتراضي عند فقدان الصورة
        }

        $palette = Palette::fromFilename($localPath);

        $topColor = $palette->getMostUsedColors(1);

        if (empty($topColor)) {
            return '#cccccc'; // لون افتراضي عند عدم إيجاد ألوان
        }

        $intColor = array_key_first($topColor);

        if (is_null($intColor)) {
            return '#cccccc'; // أيضاً حالة احتياطية
        }

        $rgb = Color::fromIntToRgb($intColor);

        return rgbToHex($rgb);
    }
}


if (!function_exists('rgbToHex')) {

    function rgbToHex($rgb)
    {
        return invertHexColor(sprintf("#%02x%02x%02x", $rgb['r'], $rgb['g'], $rgb['b']));
    }
}
if (!function_exists('invertHexColor')) {
    function invertHexColor($hexColor)
    {
        // إزالة #
        $hex = ltrim($hexColor, '#');
        // تأكد من الطول الصحيح
        if (strlen($hex) !== 6) {
            return '#000000'; // لون افتراضي
        }

        // تحويل إلى ألوان RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // عكس اللون
        $r = 255 - $r;
        $g = 255 - $g;
        $b = 255 - $b;
        // إعادة إلى hex
        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }
}

