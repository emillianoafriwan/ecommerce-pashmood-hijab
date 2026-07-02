<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class SyncCartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role !== 'admin') {
            $cartItems = CartItem::with(['product', 'variation'])
                ->where('user_id', Auth::id())
                ->get();

            $cart = [];
            foreach ($cartItems as $item) {
                if ($item->product && $item->variation) {
                    $cartKey = $item->product_id . '_' . $item->product_variation_id;
                    $cart[$cartKey] = [
                        "name"         => $item->product->name,
                        "color"        => $item->variation->color,
                        "variation_id" => $item->product_variation_id,
                        "quantity"     => $item->quantity,
                        "price"        => $item->product->price,
                        "image"        => $item->product->imageUrl()
                    ];
                }
            }
            session()->put('cart', $cart);
        }

        return $next($request);
    }
}
