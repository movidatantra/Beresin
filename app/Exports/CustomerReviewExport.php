<?php

namespace App\Exports;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CustomerReviewExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $userId;
    protected $startDate;
    protected $endDate;

    public function __construct(
        $userId,
        $startDate = null,
        $endDate = null
    )
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Review::with([
            'mitra',
            'order.service'
        ])
        ->where('user_id', $this->userId);

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

            'Mitra',

            'Layanan',

            'Rating',

            'Review'

        ];
    }

    public function map($review): array
    {
        static $no = 1;

        return [

            $no++,

            $review->created_at->format('d-m-Y'),

            $review->mitra->business_name
                ?? $review->mitra->name
                ?? '-',

            $review->order->service->name
                ?? '-',

            $review->rating . ' / 5',

            $review->review ?: '-'

        ];
    }
}