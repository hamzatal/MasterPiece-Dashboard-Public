<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class HomeController extends Controller
{
    public function index(Request $request)  // Add the $request parameter
    {

        return view('ecommerce.home');
    }}
