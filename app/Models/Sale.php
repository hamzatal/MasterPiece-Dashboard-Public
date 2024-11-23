<?php

use App\Models\Order;
use App\Http\Controllers\Controller;


class ReportController extends Controller
{
    public function index()
    {
        // Fetch the orders or sales data
        $reports = Order::all();  // Change to 'Sale' if you're using that model

        // Pass the data to the view
        return view('admin.reports.index', compact('reports'));
    }
}
