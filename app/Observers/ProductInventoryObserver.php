<?php

namespace App\Observers;

use App\Models\Tenant\ProductInventory;
use App\Jobs\Tenant\ChannelSendResourceJob;

class ProductInventoryObserver
{
    /**
     * @param \App\Models\Tenant\ProductInventory $productInventory
     * @return void
     */
    public function created(ProductInventory $productInventory)
    {
        $product = $productInventory->product;

        if ($product->price > 0) {
            ChannelSendResourceJob::dispatch($product);
        }
    }
}
