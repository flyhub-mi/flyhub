<?php

namespace App\Observers;

use App\Models\Tenant\Order;
use App\Jobs\Tenant\ChannelSendResourceJob;

class OrderObserver
{
    /**
     * @param Order $order
     * @return void
     */
    public function created(Order $order)
    {
        if ($this->orderStatusAfterPaid($order)) {
            ChannelSendResourceJob::dispatch($order);
        }
    }

    /**
     * @param Order $order
     * @return void
     */
    public function updated(Order $order)
    {
        if ($order->wasChanged('status') && $this->orderStatusAfterPaid($order)) {
            ChannelSendResourceJob::dispatch($order);
        }
    }

    /**
     * @param Order $order
     * @return bool
     */
    private function orderStatusAfterPaid($order)
    {
        return in_array($order->status, ['processing', 'em-separacao', 'Em andamento', 'Em aberto']);
    }
}
