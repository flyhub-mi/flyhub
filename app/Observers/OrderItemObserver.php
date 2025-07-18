<?php

namespace App\Observers;

use App\Models\Tenant\OrderItem;

class OrderItemObserver
{
    /**
     * @param \App\Models\Tenant\Tenant\OrderItem $orderItem
     * @return void
     */
    public function creating(OrderItem $orderItem)
    {
        $this->fillTotal($orderItem);
    }

    /**
     * @param \App\Models\Tenant\OrderItem $orderItem
     * @return void
     */
    public function updating($orderItem)
    {
        $this->fillTotal($orderItem);
    }

    /**
     * @param $orderItem
     */
    private function fillTotal($orderItem)
    {
        $orderItem->total = $orderItem->price * $orderItem->qty_ordered - $orderItem->discount_amount;
    }
}
