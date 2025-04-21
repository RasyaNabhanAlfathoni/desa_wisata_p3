<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Pelanggan;
Use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data untuk Admin
        $pelanggan = User::create([
            'email' => 'santoso123@example.com',
            'password' => Hash::make('123'), // Ganti dengan password yang aman
            'level' => 'pelanggan',
            'aktif' => 1,

        ]);

        Pelanggan::create([
            'nama_lengkap' => 'Santoso Milo',
            'no_hp' => '081390907244',
            'alamat' => 'Jl. Merdeka No. 15',
            'foto' => 'default.jpg',
            'id_user' => $pelanggan->id,
        ]);
    }
}
