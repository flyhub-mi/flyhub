<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\DataTables\Tenant\NotificationDataTable;

class NotificationController extends BaseController
{
    /**
     * @param NotificationDataTable $orderDataTable
     * @return \Illuminate\View\View
     */
    public function index(NotificationDataTable $orderDataTable)
    {
        $this->markAllAsRead();

        return $orderDataTable->render('tenant.notifications.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function clear()
    {
        $this->markAllAsRead();

        return redirect('/');
    }

    /**
     *
     */
    private function markAllAsRead()
    {
        foreach (Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
    }
}
