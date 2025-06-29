<?php

use App\Models\GeneralInfo;
use Illuminate\Support\Facades\File;

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
