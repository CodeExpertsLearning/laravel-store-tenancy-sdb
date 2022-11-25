<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Store, ShippingOption};
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(
                        private CartService $cartService, 
                        private Store $store,
                        private ShippingOption $shippingOption)
    {
    }

    public function index()
    {
        $cart = $this->cartService->all();
        $shippings = $this->shippingOption->all();

        return view('front.cart', compact('cart', 'shippings'));
    }

    public function add($subdomain, $product)
    {
        $store = $this->store->whereSubdomain($subdomain)->first();
        $product = $store->products()->whereSlug($product)->first()->toArray();

        $this->cartService->add($product);

        return redirect()->route('front.store', $subdomain);
    }

    public function remove($subdomain, $product)
    {
        $this->cartService->remove($product);

        return redirect()->route('cart.index', $subdomain);
    }

    public function cancel($subdomain)
    {
        $this->cartService->clear();
        return redirect()->route('front.store', $subdomain);
    }

    public function shipping(Request $request)
    {
        session()->put('shipping_value', $request->shipping_value);

        return response()->json([], 204);
    }
}
