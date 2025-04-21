<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Karyawan;

class AdminPemilikBendaharaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data untuk Admin
        $admin = User::create([
            'email' => 'admin@example.com',
            'password' => Hash::make('123'), // Ganti dengan password yang aman
            'level' => 'admin',
            'aktif' => 1, // Aktif

        ]);

        Karyawan::create([
            'nama_karyawan' => 'admin',
            'alamat' => 'Bojonegoro',
            'no_hp' => '081234567890',
            'jabatan' => 'administrasi',
            'id_user' => $admin->id,
        ]);

        // Data untuk Pemilik
        $pemilik = User::create([
            'email' => 'pemilik@example.com',
            'password' => Hash::make('123'), // Ganti dengan password yang aman
            'level' => 'pemilik',
            'aktif' => 1, // Aktif
        ]);

        Karyawan::create([
            'nama_karyawan' => 'pemilik',
            'alamat' => 'Bojokiro',
            'no_hp' => '081234567891',
            'jabatan' => 'pemilik',
            'id_user' => $pemilik->id,
        ]);

        // Data untuk Bendahara
        $bendahara = User::create([
            'email' => 'bendahara@example.com',
            'password' => Hash::make('123'), // Ganti dengan password yang aman
            'level' => 'bendahara',
            'aktif' => 1, // Aktif
        ]);

        Karyawan::create([
            'nama_karyawan' => 'bendahara',
            'alamat' => 'Bojokene',
            'no_hp' => '081234567892',
            'jabatan' => 'bendahara',
            'id_user' => $bendahara->id,
        ]);
    }
}
