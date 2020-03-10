<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(\Hash::make('catalin99'));

        //\Cookie::queue('cart', null));
        $categories = Category::parentCategories()->get();
        $products = Product::get();

        return view('home', compact('categories', 'products'));
    }
}
