<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CreateFakeProductsJob;
use App\Jobs\OnlineCreateFakeProductsJob;

class OnlineDispatchFakeProducts extends Command
{
    protected $signature = 'products:online-dispatch-fake';
    protected $description = 'Dispatch job to create 10 fake products in background';

    public function handle()
    {
        OnlineCreateFakeProductsJob::dispatch();
        $this->info('✅ تم إرسال مهمة إنشاء المنتجات للخلفية (Queue).');
    }
}
