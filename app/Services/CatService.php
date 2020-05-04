<?php

namespace App\Services;

use App\Services\Interfaces\CatServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class CatService implements CatServiceInterface
{
    CONST CACHE_KEY = 'CATS';

    /**
     * @param $key
     * @return string
     */
    public function getCacheKey($key)
    {
        $key = strtoupper($key);

        return self::CACHE_KEY . ".$key";
    }

    /**
     * @param $file_name
     * @return string
     */
    public function getFileContents($file_name)
    {
        $contents = "";

        if (Storage::disk('local')->exists($file_name)) {
            $contents = Storage::get($file_name);
        }

        return $contents;
    }

    /**
     * @param $file
     * @return false|string[]
     */
    public function txtFileToArrByLines($file)
    {
        return explode("\n", $file);
    }

    /**
     * @param $items
     * @param $n
     * @param int $number
     * @return mixed|string[]
     */
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

    /**
     * @param $array
     * @return string
     */
    public function arrayToCommaSeparatedString($array)
    {
        $string = "";

        if (isset($array)) {
            $string = implode (", ", $array);
        }

        return $string;
    }

    /**
     * @param $n
     * @return string
     */
    public function displayCats($n)
    {
        $file_name = 'cats.txt';

        $contents = $this->getFileContents($file_name);

        $all_cats = $this->txtFileToArrByLines($contents);

        $cats = $this->getCertainNumberOfItems($all_cats, $n, 3);

        return $this->arrayToCommaSeparatedString($cats);
    }
}
