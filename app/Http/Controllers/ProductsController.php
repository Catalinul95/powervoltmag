<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index($category, $filters = null)
    {
        if ($filters) {
            $finalFilters = [];

            if (\Str::contains($filters, '/')) {
                $filtersArr = explode('/', $filters);

                foreach ($filtersArr as $filter) {
                    $filtersArr2 = explode(':', $filter);
                    $filterName = $filtersArr2[0];
                    unset($filtersArr2[0]);
                    $finalFilters[$filterName] = implode('-', $filtersArr2);
                }
            } else {
                $filtersArr = explode(':', $filters);
                $filterName = $filtersArr[0];
                unset($filtersArr[0]);
                $filterValue = implode('-', $filtersArr);

                $finalFilters[$filterName] = $filterValue;
            }          
        }
        


        $category = Category::where('slug', $category)->first();
        $categories = Category::parentCategories()->get();

        if (!$category) {
            abort(404);
        }

        if ($category->isParentCategory()) {
            $subCategories = $category->subCategories()->pluck('id')->toArray();
            $products = Product::whereIn('category_id', $subCategories);

            if ($filters) {
                if (count($finalFilters) == 1) {
                    $products = $products->where('filters->' . $filterName, $filterValue);
                } else {
                    foreach ($finalFilters as $name => $value) {
                        $products = $products->where('filters->' . $name, $value);
                    }
                }
                $filters = json_decode(json_encode($finalFilters));
            }

            $products = $products->get();

        } else {
            $products = Product::where('category_id', $category->id);


            if ($filters) {
                if (count($finalFilters) == 1) {
                    $products = $products->where('filters->' . $filterName, $filterValue);
                } else {
                    foreach ($finalFilters as $name => $value) {
                        $products = $products->where('filters->' . $name, $value);
                    }
                }
                $filters = json_decode(json_encode($finalFilters));

            }

            $products = $products->get();
        }

        return view('products.index', compact('categories', 'category', 'products', 'filters'));
    }

    public function show($category, $product)
    {
        $category = Category::where('slug', $category)->first();
        $product = Product::where('slug', $product)->first();

        if (!$category || !$product) {
            abort(404);
        }

        $categories = Category::parentCategories()->get();

        return view('products.show', compact('categories', 'category', 'product'));
    }
}
