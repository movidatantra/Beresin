<?php

namespace App\Exports;

use App\Models\Saldopencairan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MitraWithdrawalExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $mitraId;
    protected $startDate;
    protected $endDate;

    public function __construct(
        $mitraId,
        $startDate = null,
        $endDate = null
    ) {
        $this->mitraId = $mitraId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Saldopencairan::where(
            'mitra_id',
            $this->mitraId
        );

        if ($this->startDate) {

            $query->whereDate(
                'created_at',
                '>=',
                $this->startDate
            );

        }

        if ($this->endDate) {

            $query->whereDate(
                'created_at',
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

            'Tanggal',

            'Jumlah',

            'Metode',

            'Nama Bank / E-Wallet',

            'Nomor Rekening',

            'Status'

        ];
    }

    public function map($withdraw): array
    {
        static $no = 1;

        return [

            $no++,

            $withdraw->created_at->format('d-m-Y'),

            'Rp ' . number_format(
                $withdraw->amount,
                0,
                ',',
                '.'
            ),

            ucfirst($withdraw->withdraw_type),

            $withdraw->bank_name,

            $withdraw->account_number,

            ucfirst($withdraw->status)

        ];
    }
}