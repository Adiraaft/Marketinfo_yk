<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PriceExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        // langsung simpan, tidak perlu dibungkus lagi
        $this->data = $data;
    }

    public function collection()
    {
        // pastikan baris berupa associative array, tidak object
        return $this->data->map(function ($row) {

            // ubah stdClass menjadi array dengan json_decode
            $rowArray = json_decode(json_encode($row), true);

            return [
                $rowArray['tanggal'] ?? '-',
                $rowArray['nama_commodity'] ?? '-',
                $rowArray['nama_pasar'] ?? '-',
                $rowArray['harga_rata'] ?? 0,
                $rowArray['perubahan'] ?? 0,
                $rowArray['admin'] ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Komoditas',
            'Nama Pasar',
            'Harga Rata-rata',
            'Perubahan (%)',
            'Admin'
        ];
    }
}
