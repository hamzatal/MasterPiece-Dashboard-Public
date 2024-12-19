<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopRightSidebarController extends Controller
{
    public function index()
    {
        return view('ecommerce.shop-right-sidebar');
    }
}
