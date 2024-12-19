<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductLeftSidebarController extends Controller
{
    public function index()
    {
        return view('ecommerce.product-left-sidebar');
    }
}
