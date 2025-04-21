<?php

namespace App\Exports;

use App\Models\PaketWisata;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaketWisataExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return PaketWisata::with('reservasi')->get()->map(function ($paket) {
            return [
                'nama_paket' => $paket->nama_paket,
                'deskripsi' => $paket->deskripsi,
                'fasilitas' => $paket->fasilitas,
                'harga_per_pack' => $paket->harga_per_pack,
                'durasi_hari' => $paket->durasi_hari,
                'kuota_peserta' => $paket->kuota_peserta,
                'nilai_diskon' => $paket->nilai_diskon ?? 0,
                'peserta_diskon' => $paket->peserta_diskon ?? 0,
                'jumlahDireservasi' => $paket->reservasi->count() > 0 ? $paket->reservasi->count() : 0,
                'created_at' => $paket->created_at,
                'updated_at' => $paket->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Paket',
            'Deskripsi',
            'Fasilitas',
            'Harga Paket (Rp)',
            'Durasi Hari',
            'Kuota Peserta',
            'Nilai Diskon (%)',
            'Peserta Min. Diskon',
            'Jumlah Direservasi',
            'Created At',
            'Updated At'
        ];
    }
}
