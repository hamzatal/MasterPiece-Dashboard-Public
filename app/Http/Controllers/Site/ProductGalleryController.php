<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    public function index()
    {
        return view('ecommerce.product-gallery');
    }
}
