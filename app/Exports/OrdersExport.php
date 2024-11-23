<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class OrdersExport implements FromQuery, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Order::query()->with('customer');

        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->date) {
            switch ($this->request->date) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', now()->subMonth()->month);
                    break;
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Customer Email',
            'Total',
            'Status',
            'Created At'
        ];
    }
}
