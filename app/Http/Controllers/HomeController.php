<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Test;
use  App\SocialMedia\Facebook;
use App\Repositories\Eloquent\ProductRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth:api')->except('test');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test(ProductRepository
                         $productRepository){
      echo $productRepository->getAllByCategory(9);
    }
}
