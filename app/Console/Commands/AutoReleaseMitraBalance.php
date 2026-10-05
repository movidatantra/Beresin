<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:auto-release-mitra-balance')]
#[Description('Command description')]
class AutoReleaseMitraBalance extends Command
{
    /**
     * Execute the console command.
     */
   public function handle()
{
    $orders = \App\Models\Order::where(
                    'status',
                    'menunggu_konfirmasi'
                )
                ->where(
                    'customer_confirmation',
                    'pending'
                )
                ->where(
                    'finished_at',
                    '<=',
                    now()->subDays(3)
                )
                ->get();

    foreach($orders as $order){

        $order->update([

            'status' => 'selesai',

            'customer_confirmation' => 'auto_confirmed'

        ]);

        \App\Models\MitraBalance::firstOrCreate(

    [
        'order_id' => $order->id
    ],

    [
        'mitra_id' => $order->mitra_id,
        'amount'   => $order->subtotal,
        'type'     => 'income'
    ]

);
    }

    $this->info('Auto release selesai.');
}
}
