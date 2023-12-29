<?php

namespace App\Console;

use App\Events\MidnightOrderEvent;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $eightAMOrders = Order::whereDate('delivery_time', Carbon::now()->format('Y-m-d'))
            ->whereTime('delivery_time', '08:00:00')
            ->get();

            foreach ($eightAMOrders as $order) {
                event(new MidnightOrderEvent($order));
            }
        })->dailyAt('08:00');
    
    }
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
