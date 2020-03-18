<?php

namespace App\Http\Controllers;


use Auth;
use Cookie;
use App\User;
use App\Product;
use GuzzleHttp\Client;
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

        $totalPrice = 0;

        if ($request->get('quantity') && $request->get('type') &&  Cookie::get('cart')) {
            if ($request->type != 'increase' && $request->type != 'decrease') {
                return response()->json([], 400);
            }

            $cart = Cookie::get('cart');
            $cart = json_decode($cart, true);

            foreach ($cart as $key =>$item) {
                if ($cart[$key]['id'] == $product->id) {
                    if ($request->type == 'increase') {
                        $cart[$key]['quantity'] = $cart[$key]['quantity'] + 1;
                    } else {
                        $cart[$key]['quantity'] = $cart[$key]['quantity'] - 1;
                    }

                    if ($cart[$key]['quantity'] > $product->quantity) {
                        return response()->json(['message' => 'Cantitatea e prea mare pentru acest produs.'], 400);
                    }
                   
                }
            }

            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            $totalPrice = number_format($totalPrice, 2);

            
            $cart = json_encode($cart);
            
            Cookie::queue(Cookie::make('cart', $cart, 500));


            return response()->json(['cart' => $cart, 'totalPrice' => $totalPrice], 200);
        }
            

        if (!Cookie::get('cart')) {
            $cart = [];
            $cart[] = [
                'id' => $product->id,
                'title' => $product->title,
                'code' => $product->code,
                'price' => $product->new_price,
                'imageWithUrl' => \Storage::url('/'. $product->getImages()[0]),
                'image' => $product->getImages()[0],
                'quantity' => 1,
                'stock' => $product->quantity,
            ];
            $cart = json_encode($cart);
            Cookie::queue(Cookie::make('cart', $cart, 500));
            return response()->json(['cart' => $cart, 'itemsCount' => 1, 'message' => 'The item has been added.', 'code' => 200], 200);
        } else {
            $cart = Cookie::get('cart');
            $cart = json_decode($cart, true);

            if (!\App\Cart::hasItem($product->id)) {
                $cart[] = [
                    'id' => $product->id,
                    'title' => $product->title,
                    'code' => $product->code,
                    'price' => $product->new_price,
                    'imageWithUrl' => \Storage::url('/'. $product->getImages()[0]),
                    'image' => $product->getImages()[0],
                    'quantity' => 1,
                    'stock' => $product->quantity,
                ];
                foreach ($cart as $item) {
                    $totalPrice += $item['price'] * $item['quantity'];
                }

                $totalPrice = number_format($totalPrice, 2);

                $itemsCount = count($cart);
                $cart = json_encode($cart);
                Cookie::queue(Cookie::make('cart', $cart, 500));
                return response()->json(['cart' => $cart, 'itemsCount' => $itemsCount, 'totalPrice' => $totalPrice, 'message' => 'The item has been added.', 'code' => 200], 200);
            } else {
                foreach ($cart as $key => $item) {
                    if ($item['id'] == $product->id) {
                        unset($cart[$key]);
                    }
                }
                foreach ($cart as $item) {
                    $totalPrice += $item['price'] * $item['quantity'];
                }
                $totalPrice = number_format($totalPrice, 2);

                $itemsCount = count($cart);
                $cart = json_encode($cart);
                Cookie::queue(Cookie::make('cart', $cart, 500));
                return response()->json(['cart' => $cart, 'itemsCount' => $itemsCount, 'totalPrice' => $totalPrice,  'message' => 'The item has been deleted.', 'code' => 202], 202);
            }
            
        }
    }

    public function index()
    {
        $cart = \App\Cart::getItems();

        $client = new Client(['verify' => false]);
        $res1 = $client->request('GET', 'https://roloca.coldfuse.io/judete');
        $res2 = $client->request('GET', 'https://roloca.coldfuse.io/orase');

        $judete = json_decode($res1->getBody(), true);
        $orase = json_decode($res2->getBody(), true);

        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
        } else {
            $user = null;
        }
       
        
        
        return view('cart.index', compact('cart', 'judete', 'orase', 'user'));   
    }
}
