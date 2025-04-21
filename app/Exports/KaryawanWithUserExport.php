<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanWithUserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Karyawan::with('user')->get()->map(function ($karyawan) {
            return [
                'email' => $karyawan->user->email ?? '-',
                'level' => $karyawan->user->level ?? '-',
                'aktif' => $karyawan->user->aktif == 1 ? 'Aktif' : 'Nonaktif',
                'nama_karyawan' => $karyawan->nama_karyawan,
                'alamat' => $karyawan->alamat,
                'no_hp' => $karyawan->no_hp,
                'jabatan' => $karyawan->jabatan,
                'created_at' => $karyawan->created_at,
                'updated_at' => $karyawan->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Email',
            'Level',
            'Status Akun',
            'Nama Karyawan',
            'Alamat',
            'No HP',
            'Jabatan',
            'Created At',
            'Updated At'
        ];
    }
}


