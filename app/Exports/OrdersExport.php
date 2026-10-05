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

class OrdersExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithCustomStartCell
{
    protected $startDate;
    protected $endDate;
    protected $status;

    public function __construct($startDate = null, $endDate = null, $status = null)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->status    = $status;
    }

    public function startCell(): string
    {
        return 'A6';
    }

    public function collection()
    {
        $query = Order::with([
            'user',
            'mitra',
            'service'
        ]);

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        if ($this->status) {
            $query->where('status', $this->status);
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
            'Layanan',
            'Total',
            'Pembayaran',
            'Status'
        ];
    }

    public function map($order): array
    {
        static $no = 1;

        return [

            $no++,

            'ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT),

            Carbon::parse($order->created_at)->format('d-m-Y'),

            $order->user->name ?? '-',

            $order->mitra->name ?? '-',

            optional($order->service)->name ?? '-',

            'Rp ' . number_format($order->total_price, 0, ',', '.'),

            ucfirst($order->payment_status),

            ucfirst($order->status)

        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');

        $sheet->setCellValue(
            'A1',
            'LAPORAN ORDER BERES.IN'
        );

        $sheet->setCellValue(
            'A2',
            'Tanggal Cetak : ' .
            Carbon::now('Asia/Jakarta')->translatedFormat('d F Y H:i') .
            ' WIB'
        );

        $periode = 'Semua';

        if ($this->startDate || $this->endDate) {
            $periode =
                ($this->startDate ?? '-') .
                ' s/d ' .
                ($this->endDate ?? '-');
        }

        $sheet->setCellValue(
            'A3',
            'Periode : ' . $periode
        );

        $sheet->setCellValue(
            'A4',
            'Status : ' . ($this->status ?: 'Semua Status')
        );

        // Judul
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(18);

        // Header tabel
        $sheet->getStyle('A6:I6')->applyFromArray([
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
        ]);

        $lastRow = $sheet->getHighestRow();

        $sheet->getStyle("A6:I{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
    }
}