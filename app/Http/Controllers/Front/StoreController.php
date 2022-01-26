<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index($subdomain, Store $store)
    {
        $store = $store->whereSubdomain($subdomain)
                      ->with('products')
                      ->first();

        return view('front.home', compact('store'));
    }
}
