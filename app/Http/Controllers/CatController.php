<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CatServiceInterface;

class CatController extends Controller
{
    /**
     * @var CatServiceInterface
     */
    protected $catService;

    /**
     * CatController constructor.
     * @param CatServiceInterface $catServiceInterface
     */
    public function __construct(CatServiceInterface $catServiceInterface)
    {
        $this->catService = $catServiceInterface;
    }

    /**
     * @param $n
     * @return mixed
     */
    public function index($n)
    {
        return $this->catService->displayCats($n);
    }
}
