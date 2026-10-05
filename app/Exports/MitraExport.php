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

class MitraExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents
{
    protected $search;
    protected $verificationStatus;
    protected $specialization;

    public function __construct(
        $search = null,
        $verificationStatus = null,
        $specialization = null
    ) {
        $this->search = $search;
        $this->verificationStatus = $verificationStatus;
        $this->specialization = $specialization;
    }

    public function collection()
    {
        $query = User::where('role', 'mitra');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('business_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->verificationStatus) {
            $query->where(
                'verification_status',
                $this->verificationStatus
            );
        }

        if ($this->specialization) {
            $query->where(
                'specialization',
                'like',
                '%' . $this->specialization . '%'
            );
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Mitra',
            'Nama Usaha',
            'Spesialisasi',
            'No HP',
            'Email',
            'Status Verifikasi',
            'Pendapatan'
        ];
    }

    public function map($mitra): array
    {
        static $no = 1;

        $income = Order::where('mitra_id', $mitra->id)
            ->where('payment_status', 'lunas')
            ->sum('total_price');

        return [
            $no++,
            $mitra->name,
            $mitra->business_name,
            $mitra->specialization,
            $mitra->phone,
            $mitra->email,
            ucfirst($mitra->verification_status),
            $income
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            // Header tabel
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12
                ],

                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => [
                        'rgb' => '2563EB'
                    ]
                ],

                'alignment' => [
                    'horizontal' => 'center'
                ]
            ]

        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                // Judul
                $sheet->insertNewRowBefore(1,4);

                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue(
                    'A1',
                    'LAPORAN DATA MITRA BERES.IN'
                );

                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue(
                    'A2',
                    'Tanggal Cetak : '.now()->timezone('Asia/Jakarta')->format('d F Y H:i').' WIB'
                );

                $sheet->mergeCells('A3:H3');

                $sheet->getStyle('A1')->getFont()
                    ->setBold(true)
                    ->setSize(18);

                $sheet->getStyle('A2')->getFont()
                    ->setItalic(true);

                $sheet->getStyle('A1:A2')
                    ->getAlignment()
                    ->setHorizontal('center');

                // Format Rupiah
                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("H6:H{$lastRow}")
                    ->getNumberFormat()
                    ->setFormatCode('"Rp" #,##0');

                // Border
                $sheet->getStyle("A5:H{$lastRow}")
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => 'thin'
                            ]
                        ]
                    ]);

            }

        ];
    }
}