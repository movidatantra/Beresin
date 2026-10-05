<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = User::where('role', 'pelanggan');

        if ($this->search) {

            $query->where(function ($q) {

                $q->where('name','like','%'.$this->search.'%')
                  ->orWhere('email','like','%'.$this->search.'%');

            });

        }

        return $query->get();
    }

    public function headings(): array
    {
        return [

            'No',

            'Nama',

            'Email',

            'No HP',

            'Total Booking',

            'Total Transaksi',

            'Status'

        ];
    }

    public function map($customer): array
    {
        static $no = 1;

        $booking = Order::where(
            'user_id',
            $customer->id
        )->count();

        $total = Order::where(
            'user_id',
            $customer->id
        )
        ->where('payment_status','lunas')
        ->sum('total_price');

        return [

            $no++,

            $customer->name,

            $customer->email,

            $customer->phone,

            $booking,

            $total,

            $booking > 0
                ? 'Aktif'
                : 'Belum Pernah Order'

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            5 => [

                'font'=>[
                    'bold'=>true,
                    'color'=>[
                        'rgb'=>'FFFFFF'
                    ]
                ],

                'fill'=>[
                    'fillType'=>'solid',
                    'startColor'=>[
                        'rgb'=>'2563EB'
                    ]
                ]

            ]

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function(AfterSheet $event){

                $sheet = $event->sheet;

                $sheet->insertNewRowBefore(1,4);

                $sheet->mergeCells('A1:G1');

                $sheet->setCellValue(
                    'A1',
                    'LAPORAN DATA PELANGGAN BERES.IN'
                );

                $sheet->mergeCells('A2:G2');

                $sheet->setCellValue(
                    'A2',
                    'Tanggal Cetak : '.now()->timezone('Asia/Jakarta')->format('d F Y H:i').' WIB'
                );

                $sheet->getStyle('A1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(18);

                $sheet->getStyle('A2')
                    ->getFont()
                    ->setItalic(true);

                $sheet->getStyle('A1:A2')
                    ->getAlignment()
                    ->setHorizontal('center');

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A5:G{$lastRow}")
                    ->applyFromArray([

                        'borders'=>[

                            'allBorders'=>[

                                'borderStyle'=>'thin'

                            ]

                        ]

                    ]);

                $sheet->getStyle("F6:F{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

            }

        ];
    }
}