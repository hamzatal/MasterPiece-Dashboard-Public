<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    public function index()
    {
        return view('ecommerce.product-gallery');
    }
}
