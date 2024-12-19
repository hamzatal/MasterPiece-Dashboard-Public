<?php
namespace App\Exports;

use Illuminate\Http\Request;

class OrdersExport
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        // Example: Use $this->request to filter orders
        return \App\Models\Order::query()->get();
    }
}
