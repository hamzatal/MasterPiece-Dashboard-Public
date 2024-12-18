<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopRightSidebarController extends Controller
{
    public function index()
    {
        return view('ecommerce.shop-right-sidebar');
    }
}
