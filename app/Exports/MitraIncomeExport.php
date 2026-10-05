<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MitraIncomeExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected $mitraId;
    protected $startDate;
    protected $endDate;

    public function __construct($mitraId, $startDate = null, $endDate = null)
    {
        $this->mitraId = $mitraId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Order::with([
            'user',
            'service'
        ])
        ->where('mitra_id', $this->mitraId)
        ->where('payment_status', 'lunas');

        if ($this->startDate) {
            $query->whereDate('jadwal', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('jadwal', '<=', $this->endDate);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Pelanggan',
            'Layanan',
            'Metode Pembayaran',
            'Status',
            'Total'
        ];
    }

    public function map($order): array
    {
        static $no = 1;

        return [

            $no++,

            $order->jadwal,

            $order->user->name ?? '-',

            $order->service->name ?? '-',

            $order->payment_method,

            ucfirst($order->status),

            $order->total_price

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            5 => [

                'font' => [

                    'bold' => true,

                    'color' => [
                        'rgb' => 'FFFFFF'
                    ]

                ],

                'fill' => [

                    'fillType' => 'solid',

                    'startColor' => [
                        'rgb' => '2563EB'
                    ]

                ]

            ]

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                $sheet->insertNewRowBefore(1, 4);

                $sheet->mergeCells('A1:G1');

                $sheet->setCellValue(
                    'A1',
                    'LAPORAN PENDAPATAN MITRA BERES.IN'
                );

                $sheet->mergeCells('A2:G2');

                $sheet->setCellValue(
                    'A2',
                    'Tanggal Cetak : ' .
                    now()->timezone('Asia/Jakarta')->format('d F Y H:i') .
                    ' WIB'
                );

                $sheet->getStyle('A1')->getFont()
                    ->setBold(true)
                    ->setSize(18);

                $sheet->getStyle('A2')->getFont()
                    ->setItalic(true);

                $sheet->getStyle('A1:A2')
                    ->getAlignment()
                    ->setHorizontal('center');

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A5:G{$lastRow}")
                    ->applyFromArray([

                        'borders' => [

                            'allBorders' => [

                                'borderStyle' => 'thin'

                            ]

                        ]

                    ]);

                $sheet->getStyle("G6:G{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

            }

        ];
    }
}