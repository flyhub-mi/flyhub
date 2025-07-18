<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Tenant;
use App\Models\User;

class DashboardController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.dashboard')
            ->with('tenantsCount', Tenant::count())
            ->with('usersCount', User::count())
            ->with('daysOfCurrentMonth', $this->daysOfCurrentMonth())
            ->with('tenantsByDayOfCurrentMonth', $this->tenantsByDayOfCurrentMonth());
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
    private function tenantsByDayOfCurrentMonth()
    {
        $days = array_fill(0, sizeof($this->daysOfCurrentMonth()), 0);

        $tenantsByDay = Tenant::whereMonth('created_at', date('m'))
            ->get()
            ->groupBy(fn ($invoice) => $invoice->created_at->format('d'))
            ->map(fn ($day) => $day->sum('grand_total'))
            ->toArray();

        foreach ($tenantsByDay as $key => $value) {
            $days[intval($key) - 1] = $value;
        }

        return $days;
    }
}
