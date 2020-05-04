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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($n)
    {
        $route_visits = $this->catService->countVisits($n);
        $total_visits = $this->catService->countVisits('total');
        $cats = $this->catService->CatsString($n);

        return view('cats.index')->with(compact('route_visits','total_visits', 'cats'));
    }
}
