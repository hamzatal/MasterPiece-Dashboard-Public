<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductLeftSidebarController extends Controller
{
    public function index()
    {
        return view('ecommerce.product-left-sidebar');
    }
}
