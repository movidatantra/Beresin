<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerPaymentExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $userId;
    protected $paymentStatus;
    protected $startDate;
    protected $endDate;

    public function __construct(
        $userId,
        $paymentStatus = null,
        $startDate = null,
        $endDate = null
    )
    {
        $this->userId = $userId;
        $this->paymentStatus = $paymentStatus;
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

        if ($this->paymentStatus) {

            $query->where(
                'payment_status',
                $this->paymentStatus
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

            'Metode Pembayaran',

            'Status Pembayaran',

            'Total'

        ];
    }

    public function map($payment): array
    {
        static $no = 1;

        return [

            $no++,

            $payment->invoice_number,

            $payment->jadwal,

            $payment->jam,

            $payment->mitra->business_name
                ?? $payment->mitra->name
                ?? '-',

            $payment->service->name
                ?? '-',

            ucfirst($payment->payment_method),

            ucfirst($payment->payment_status),

            'Rp ' . number_format(
                $payment->total_price,
                0,
                ',',
                '.'
            )

        ];
    }
}