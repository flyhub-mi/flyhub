<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Order;
use App\Models\Tenant\Invoice;
use App\Models\Tenant\Product;
use App\Models\Tenant\Shipment;
use App\Http\Controllers\BaseController;

class DashboardController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('tenant.dashboard')
            ->with('ordersCount', Order::count())
            ->with('shipmentsCount', Shipment::count())
            ->with('productsCount', Product::where('parent_id', null)->count())
            ->with('monthSalesSum', Invoice::sum('grand_total'))
            ->with('daysOfCurrentMonth', $this->daysOfCurrentMonth())
            ->with('salesByDayOfCurrentMonth', $this->salesByDayOfCurrentMonth());
    }

    /**
     * @return array
     */
    private function daysOfCurrentMonth()
    {
        return range(1, date('t'));
    }

    /**
     * @return array
     */
    private function salesByDayOfCurrentMonth()
    {
        $days = array_fill(0, sizeof($this->daysOfCurrentMonth()), 0);

        $salesByDay = Invoice::whereMonth('created_at', date('m'))
            ->get()
            ->groupBy(fn ($invoice) => $invoice->created_at->format('d'))
            ->map(fn ($day, $index) => $day->sum('grand_total'))
            ->toArray();

        foreach ($salesByDay as $key => $value) {
            $days[intval($key) - 1] = $value;
        }

        return $days;
    }
}
