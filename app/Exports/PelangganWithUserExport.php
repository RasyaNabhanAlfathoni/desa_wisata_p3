<?php

namespace App\Exports;

use App\Models\Pelanggan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PelangganWithUserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pelanggan::with('user')->get()->map(function ($pelanggan) {
            return [
                'email' => $pelanggan->user->email ?? '-',
                'level' => $pelanggan->user->level ?? '-',
                'aktif' => $pelanggan->user->aktif == 1 ? 'Aktif' : 'Nonaktif',
                'nama_pelanggan' => $pelanggan->nama_lengkap,
                'alamat' => $pelanggan->alamat,
                'no_hp' => $pelanggan->no_hp,
                'jumlahReservasi' => $pelanggan->reservasi->count() > 0 ? $pelanggan->reservasi->count() : 0,
                'created_at' => $pelanggan->created_at,
                'updated_at' => $pelanggan->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Email',
            'Level',
            'Status Akun',
            'Nama Pelanggan',
            'Alamat',
            'No HP',
            'Jumlah Reservasi',
            'Created At',
            'Updated At'
        ];
    }
}
