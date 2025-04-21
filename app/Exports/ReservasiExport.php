<?php

namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReservasiExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Reservasi::with(['pelanggan', 'paket'])->get();
    }

    public function map($reservasi): array
    {
        return [
            $reservasi->id,
            $reservasi->pelanggan->nama_lengkap ?? '-',
            $reservasi->pelanggan->no_hp ?? '-',
            $reservasi->pelanggan->alamat ?? '-',
            $reservasi->paket->nama_paket ?? '-',
            $reservasi->tgl_reservasi_mulai,
            $reservasi->tgl_reservasi_akhir,
            $reservasi->jumlah_peserta,
            $reservasi->harga,
            $reservasi->diskon,
            $reservasi->nilai_diskon,
            $reservasi->total_bayar,
            $reservasi->status_reservasi_wisata,
            $reservasi->created_at,
            $reservasi->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID Reservasi',
            'Nama Pelanggan',
            'No HP',
            'Alamat',
            'Nama Paket Wisata',
            'Tgl Reservasi Mulai',
            'Tgl Reservasi Akhir',
            'Jumlah Peserta',
            'Harga (Rp)',
            'Diskon (Rp)',
            'Nilai Diskon (%)',
            'Total Bayar (Rp)',
            'Status',
            'Created At',
            'Updated At'
        ];
    }

}
