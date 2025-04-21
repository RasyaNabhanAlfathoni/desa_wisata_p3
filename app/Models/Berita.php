<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';

    protected $fillable = [
        'judul', 'berita', 'tgl_post', 'foto', 'id_kategori_berita'
    ];

    protected $casts = [
        'tgl_post' => 'datetime', // Pastikan tgl_post dikonversi menjadi datetime
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'id_kategori_berita');
    }
}
