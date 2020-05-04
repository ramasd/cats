<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class CatController extends Controller
{
    CONST CACHE_KEY = 'CATS';

    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY . ".$key";
    }
    public function index($n)
    {
        $file_name = 'cats.txt';

        $contents = $this->getFileContents($file_name);

        $all_cats = $this->txtFileToArrByLines($contents);

        $cats = $this->getCertainNumberOfItems($all_cats, $n, 3);

        return $this->arrayToCommaSeparatedString($cats);
    }

    public function getFileContents($file_name)
    {
        $contents = "";

        if (Storage::disk('local')->exists($file_name)) {
            $contents = Storage::get($file_name);
        }

        return $contents;
    }

    public function txtFileToArrByLines($file)
    {
        return explode("\n", $file);
    }

    public function getCertainNumberOfItems($items, $n, $number = 1)
    {
        $key = "numberOfItems.$n";
        $cacheKey = $this->getCacheKey($key);

        if ($number > count($items)) {
            $number = count($items);
        }

        try {
            return cache()->remember($cacheKey, Carbon::now()->addMinute(), function () use ($items, $number) {
                return Arr::random($items, $number);
            });
        } catch (\Exception $e) {
            return $array = ['Something is wrong!'];
        }
    }

    public function arrayToCommaSeparatedString($array)
    {
        $string = "";

        if (isset($array)) {
            $string = implode (", ", $array);
        }

        return $string;
    }
}
