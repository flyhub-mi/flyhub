<?php

namespace App\Observers;

use App\Models\Tenant\Product;
use App\Jobs\Tenant\ChannelSendResourceJob;

class ProductObserver
{
    /**
     * @param \App\Models\Tenant\Product $product
     * @return void
     */
    public function created(Product $product)
    {
        if ($product->status === 'enabled') {
            ChannelSendResourceJob::dispatch($product);
        }
    }

    /**
     * @param \App\Models\Tenant\Product $product
     * @return void
     */
    public function updated(Product $product)
    {
        if ($product->wasChanged('price') || $product->wasChanged('status')) {
            ChannelSendResourceJob::dispatch($product);
        }
    }
}
