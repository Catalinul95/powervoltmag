<?php

namespace App;

use Cookie;

class Cart
{
    public static function hasItem($id)
    {
        if (Cart::isSet()) {
            $cart = json_decode(Cookie::get('cart'), true);

            foreach ($cart as $item) {
                if ($item['id'] == $id) {
                    return true;
                }
            }
        }

        return null;
    }

    public static function isSet()
    {
        return \Cookie::get('cart') ? true : false;
    }

    public static function countItems()
    {
        $cart = json_decode(Cookie::get('cart'), true);

        if (!$cart) {
            return 0;
        }

        return count($cart);
    }

    public static function getItems()
    {
        $cart = json_decode(Cookie::get('cart'), true);

        return $cart;
    }

    public static function deleteCart()
    {
        Cookie::queue(
            Cookie::forget('cart')
        );
    }
}
