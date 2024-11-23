<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::select('id', 'customer_id', 'total_price', 'created_at')
            ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Customer ID', 'Total Price', 'Created At'];
    }
}
