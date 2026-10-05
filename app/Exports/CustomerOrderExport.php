<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerOrderExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $userId;
    protected $status;
    protected $startDate;
    protected $endDate;

    public function __construct(
        $userId,
        $status = null,
        $startDate = null,
        $endDate = null
    ) {
        $this->userId = $userId;
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Order::with([
            'mitra',
            'service'
        ])
        ->where('user_id', $this->userId);

        if ($this->status) {

            $query->where(
                'status',
                $this->status
            );

        }

        if ($this->startDate) {

            $query->whereDate(
                'jadwal',
                '>=',
                $this->startDate
            );

        }

        if ($this->endDate) {

            $query->whereDate(
                'jadwal',
                '<=',
                $this->endDate
            );

        }

        return $query
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [

            'No',

            'Invoice',

            'Tanggal',

            'Jam',

            'Mitra',

            'Layanan',

            'Status Order',

            'Status Pembayaran',

            'Metode Pembayaran',

            'Total'

        ];
    }

    public function map($order): array
    {
        static $no = 1;

        return [

            $no++,

            $order->invoice_number,

            $order->jadwal,

            $order->jam,

            $order->mitra->business_name
                ?? $order->mitra->name
                ?? '-',

            $order->service->name
                ?? '-',

            ucfirst($order->status),

            ucfirst($order->payment_status),

            ucfirst($order->payment_method),

            'Rp ' . number_format(
                $order->total_price,
                0,
                ',',
                '.'
            )

        ];
    }
}