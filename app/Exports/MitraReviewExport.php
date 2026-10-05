<?php

namespace App\Exports;

use App\Models\Review;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MitraReviewExport implements
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
        $query = Review::with('user')
            ->where('mitra_id', $this->mitraId);

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

            'Pelanggan',

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

            $review->user->name ?? '-',

            $review->rating,

            $review->review

        ];
    }
}