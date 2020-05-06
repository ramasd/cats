<?php

namespace App\Services;

use App\Services\Interfaces\CatServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
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
     * @param $fileName
     * @return string
     */
    public function getFileContents($fileName)
    {
        $contents = "";

        if (Storage::disk('local')->exists($fileName)) {
            $contents = Storage::get($fileName);
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
     * @return mixed|string[]
     */
    public function catsArray($n)
    {
        $fileName = 'cats.txt';

        $contents = $this->getFileContents($fileName);

        $allCats = $this->txtFileToArrByLines($contents);

        return $this->getCertainNumberOfItems($allCats, $n, 3);
    }

    /**
     * @param $n
     * @return string
     */
    public function catsString($n)
    {
        $cats = $this->catsArray($n);

        return $this->arrayToCommaSeparatedString($cats);
    }

    /**
     * @param $visits
     * @return mixed
     */
    public function countVisits($visits)
    {
        return Redis::incr($visits);
    }

    /**
     * @param $data
     */
    public function storeLog($data)
    {
        Storage::append('log.json', \GuzzleHttp\json_encode($data));
    }

    /**
     * @param $n
     */
    public function logData($n)
    {
        $countN = $this->countVisits($n);
        $countAll = $this->countVisits('all');
        $catsArray = $this->CatsArray($n);
        $dateTime = Carbon::now()->format("Y-M-d H:i:s");

        $data = [
            "datetime" => $dateTime,
            "N" => $n,
            "Cats" => $catsArray,
            "countAll" => $countAll,
            "countN" => $countN
        ];

        Storage::append('log.json', \GuzzleHttp\json_encode($data));
    }
}
