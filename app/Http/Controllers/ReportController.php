<?php

namespace App\Http\Controllers;

use App\Models\Order;  // Adjust this if you're using a different model, such as 'Sale'
use Illuminate\Http\Request;

class ReportController extends Controller  // Inherit from Controller
{
    public function index()
    {
        // Fetch sales data (adjust this according to your actual data structure)
        $reports = Order::all();  // Replace with your actual model

        // Pass the data to the view
        return view('admin.reports.index', compact('reports'));
    }
}
