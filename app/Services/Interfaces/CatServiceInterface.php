<?php

namespace App\Services\Interfaces;

interface CatServiceInterface
{
    /**
     * @param $key
     * @return string
     */
    public function getCacheKey($key);

    /**
     * @param $file_name
     * @return string
     */
    public function getFileContents($file_name);

    /**
     * @param $file
     * @return false|string[]
     */
    public function txtFileToArrByLines($file);

    /**
     * @param $items
     * @param $n
     * @param int $number
     * @return mixed|string[]
     */
    public function getCertainNumberOfItems($items, $n, $number = 1);

    /**
     * @param $array
     * @return string
     */
    public function arrayToCommaSeparatedString($array);

    /**
     * @param $n
     * @return string
     */
    public function CatsString($n);

    /**
     * @param $visits
     * @return mixed
     */
    public function countVisits($visits);
}
