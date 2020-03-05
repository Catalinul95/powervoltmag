<?php

namespace App\Http\Controllers;

use App\Product;
use Cookie;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        if (!$request->get('id')) {
            return response()->json(['error' => 'Invalid product.'], 400);
        }

        $product = Product::find($request->id);

        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        if (!Cookie::get('cart')) {
            $cart = [];
            $cart[] = $product->id;
            $cart = json_encode($cart);
            Cookie::queue(Cookie::make('cart', $cart, 500));
            return response()->json(['cart' => $cart, 'itemCount' => 1, 'message' => 'The item has been added.', 'code' => 200], 200);
        } else {
            $cart = Cookie::get('cart');
            $cart = json_decode($cart, true);

            if (!in_array($product->id, $cart)) {
                $cart[] = $product->id;
                $itemsCount = count($cart);
                $cart = json_encode($cart);
                Cookie::queue(Cookie::make('cart', $cart, 500));
                return response()->json(['cart' => $cart, 'itemsCount' => $itemsCount, 'message' => 'The item has been added.', 'code' => 200], 200);
            } else {
                $cart = array_diff($cart, [$product->id]);
                $itemsCount = count($cart);
                $cart = json_encode($cart);
                Cookie::queue(Cookie::make('cart', $cart, 500));
                return response()->json(['cart' => $cart, 'itemsCount' => $itemsCount, 'message' => 'The item has been deleted.', 'code' => 202], 202);
            }
            
        }

       

        
    }
}
