<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class IncomeExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithCustomStartCell
{
    protected $startDate;
    protected $endDate;
    protected $paymentMethod;

    public function __construct($startDate = null, $endDate = null, $paymentMethod = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->paymentMethod = $paymentMethod;
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function collection()
    {
        $query = Order::with([
            'user',
            'mitra'
        ])->where('payment_status','lunas');

        if($this->startDate){
            $query->whereDate('jadwal','>=',$this->startDate);
        }

        if($this->endDate){
            $query->whereDate('jadwal','<=',$this->endDate);
        }

        if($this->paymentMethod){

            if($this->paymentMethod == 'bank'){

                $query->where('payment_method','BANK_TRANSFER');

            }elseif($this->paymentMethod == 'ewallet'){

                $query->whereIn('payment_method',[
                    'GOPAY',
                    'OVO',
                    'DANA',
                    'SHOPEEPAY',
                    'LINKAJA',
                    'QRIS'
                ]);

            }

        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [

            'No',

            'Kode Order',

            'Tanggal',

            'Pelanggan',

            'Mitra',

            'Metode',

            'Pendapatan',

            'Status'

        ];
    }

    public function map($order): array
    {

        static $no=1;

        return [

            $no++,

            'ORD-'.str_pad($order->id,5,'0',STR_PAD_LEFT),

            Carbon::parse($order->jadwal)->format('d-m-Y'),

            $order->user->name ?? '-',

            $order->mitra->name ?? '-',

            $order->payment_method,

            $order->total_price,

            ucfirst($order->status)

        ];

    }

    public function styles(Worksheet $sheet)
    {

        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');

        $sheet->setCellValue('A1','LAPORAN PENDAPATAN BERES.IN');

        $sheet->setCellValue(
            'A2',
            'Tanggal Cetak : '.
            Carbon::now('Asia/Jakarta')->format('d F Y H:i').' WIB'
        );

        $sheet->setCellValue(
            'A3',
            'Periode : '.
            ($this->startDate ?? '-') .
            ' s/d ' .
            ($this->endDate ?? '-')
        );

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);

        $sheet->getStyle('A6:H6')->applyFromArray([

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

        ]);

        $lastRow=$sheet->getHighestRow();

        $sheet->getStyle("A6:H{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

    }
}