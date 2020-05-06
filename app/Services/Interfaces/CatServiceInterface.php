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
     * @param $fileName
     * @return string
     */
    public function getFileContents($fileName);

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
     * @return mixed|string[]
     */
    public function catsArray($n);

    /**
     * @param $n
     * @return string
     */
    public function catsString($n);

    /**
     * @param $visits
     * @return mixed
     */
    public function countVisits($visits);

    /**
     * @param $data
     */
    public function storeLog($data);

    /**
     * @param $n
     */
    public function logData($n);
}
