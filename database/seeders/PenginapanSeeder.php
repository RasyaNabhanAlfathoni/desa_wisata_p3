<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penginapan;

class PenginapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Data PENGINAPAN
         // Data penginapan 1
         Penginapan::create([
            'nama_penginapan' => 'Homestay Tradisional Penglipuran',
            'deskripsi' => 'Penginapan dengan nuansa tradisional Bali yang autentik di jantung Desa Penglipuran.',
            'fasilitas' => 'Kamar ber-AC, WiFi gratis, Kamar mandi dalam, Sarapan khas Bali',
            'foto1' => 'homestay1.jpg',
            'foto2' => 'homestay2.jpg',
            'foto3' => 'homestay3.jpg',
            'foto4' => 'homestay4.jpg',
            'foto5' => 'homestay5.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Data penginapan 2
        Penginapan::create([
            'nama_penginapan' => 'Bamboo Eco Retreat',
            'deskripsi' => 'Penginapan ramah lingkungan dengan bahan utama bambu, dikelilingi hutan bambu alami.',
            'fasilitas' => 'Kipas angin, Kamar mandi luar, Restoran organik, Area bersantai',
            'foto1' => 'bamboo1.jpg',
            'foto2' => 'bamboo2.jpg',
            'foto3' => 'bamboo3.jpg',
            'foto4' => 'bamboo4.jpg',
            'foto5' => 'bamboo5.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Data penginapan 3
        Penginapan::create([
            'nama_penginapan' => 'Villa Taman Sari',
            'deskripsi' => 'Villa mewah dengan taman tropis dan kolam renang pribadi, cocok untuk keluarga.',
            'fasilitas' => 'AC, Kolam renang pribadi, Dapur lengkap, Kamar mandi mewah, WiFi',
            'foto1' => 'villa1.jpg',
            'foto2' => 'villa2.jpg',
            'foto3' => 'villa3.jpg',
            'foto4' => 'villa4.jpg',
            'foto5' => 'villa5.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Data penginapan 4
        Penginapan::create([
            'nama_penginapan' => 'Rumah Adat Penglipuran',
            'deskripsi' => 'Pengalaman menginap di rumah adat Bali asli dengan arsitektur tradisional.',
            'fasilitas' => 'Kamar tradisional, Kamar mandi bersama, Sarapan lokal, Pengalaman budaya',
            'foto1' => 'rumah1.jpg',
            'foto2' => 'rumah2.jpg',
            'foto3' => 'rumah3.jpg',
            'foto4' => 'rumah4.jpg',
            'foto5' => 'rumah5.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Data penginapan 5
        Penginapan::create([
            'nama_penginapan' => 'The Green Bungalow',
            'deskripsi' => 'Bungalow nyaman dikelilingi oleh vegetasi hijau dan suasana pedesaan yang tenang.',
            'fasilitas' => 'Teras pribadi, Kipas angin, WiFi, Kamar mandi dalam, Restoran kecil',
            'foto1' => 'bungalow1.jpg',
            'foto2' => 'bungalow2.jpg',
            'foto3' => 'bungalow3.jpg',
            'foto4' => 'bungalow4.jpg',
            'foto5' => 'bungalow5.jpg',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
