<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BookingSlot;

class BookingController extends Controller
{
    public function testHaversine()
    {
        // ==========================
        // DATA PELANGGAN (TESTING)
        // ==========================
        $customerLat = -6.900000;
        $customerLng = 109.200000;

        // Layanan yang dipilih pelanggan
        $layanan = 'cuci AC';

        // Tanggal dan jam booking
        $tanggal = '2026-07-10';
        $jam = '09:00:00';

        // ==========================
        // CARI MITRA BERDASARKAN LAYANAN + JARAK
        // ==========================
        $mitras = User::selectRaw("
            *,
            (
                6371 * acos(
                    cos(radians(?))
                    * cos(radians(latitude))
                    * cos(radians(longitude) - radians(?))
                    + sin(radians(?))
                    * sin(radians(latitude))
                )
            ) AS distance
        ", [
            $customerLat,
            $customerLng,
            $customerLat
        ])
        ->where('role', 'mitra')

        ->whereHas('services', function ($q) use ($layanan) {
            $q->where('name', $layanan);
        })

        ->whereNotNull('latitude')
        ->whereNotNull('longitude')

        ->orderBy('distance')

        ->get();

        // ==========================
        // JALANKAN ALGORITMA GREEDY
        // ==========================
        $mitraTerpilih = $this->pilihMitraGreedy(
            $mitras,
            $tanggal,
            $jam
        );

        // ==========================
        // HASIL
        // ==========================
        if (!$mitraTerpilih) {

            return response()->json([
                'success' => false,
                'message' => 'Tidak ada mitra yang tersedia'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mitra ditemukan',

            'mitra' => [
                'id' => $mitraTerpilih->id,
                'name' => $mitraTerpilih->name,
                'business_name' => $mitraTerpilih->business_name,
                'distance' => round($mitraTerpilih->distance, 2) . ' KM'
            ]
        ]);
    }

    /**
     * ALGORITMA GREEDY
     * Pilih mitra terdekat yang slotnya tersedia
     */
    private function pilihMitraGreedy($mitras, $tanggal, $jam)
    {
        foreach ($mitras as $mitra) {

            $slot = BookingSlot::where('mitra_id', $mitra->id)
                ->where('tanggal', $tanggal)
                ->where('jam', $jam)
                ->where('status', 'tersedia')
                ->first();

            if ($slot) {

                // GREEDY:
                // langsung pilih mitra pertama
                return $mitra;
            }
        }

        return null;
    }
}