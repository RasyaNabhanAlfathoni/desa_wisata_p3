<?php

namespace App\Exports;

use App\Models\Reservasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanKeuanganExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $reservasi = Reservasi::query();

        if ($this->request->filled('nama_lengkap')) {
            $reservasi->where('id_pelanggan', $this->request->nama_lengkap);
        }

        if ($this->request->filled('paket_wisata')) {
            $reservasi->where('id_paket', $this->request->paket_wisata);
        }

        if ($this->request->filled('status')) {
            $reservasi->where('status_reservasi_wisata', $this->request->status);
        }

        if ($this->request->filled('tanggal_awal') && $this->request->filled('tanggal_akhir')) {
            $reservasi->whereBetween('tgl_reservasi_mulai', [
                $this->request->tanggal_awal,
                $this->request->tanggal_akhir
            ]);
        }

        return $reservasi->with(['pelanggan', 'paket'])->get()->map(function ($item) {
            return [
                'Nama Pelanggan' => $item->pelanggan->nama_lengkap ?? '-',
                'Paket Wisata' => $item->paket->nama_paket ?? '-',
                'Tanggal Mulai' => $item->tgl_reservasi_mulai,
                'Jumlah Peserta' => $item->jumlah_peserta,
                'Total Bayar' => $item->total_bayar,
                'Status' => $item->status_reservasi_wisata,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'Paket Wisata',
            'Tanggal Mulai',
            'Jumlah Peserta',
            'Total Bayar',
            'Status',
        ];
    }
}
