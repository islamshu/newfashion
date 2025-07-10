<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CreateFakeProductsJob;

class DispatchFakeProducts extends Command
{
    protected $signature = 'products:dispatch-fake';
    protected $description = 'Dispatch job to create 10 fake products in background';

    public function handle()
    {
        CreateFakeProductsJob::dispatch();
        $this->info('✅ تم إرسال مهمة إنشاء المنتجات للخلفية (Queue).');
    }
}
