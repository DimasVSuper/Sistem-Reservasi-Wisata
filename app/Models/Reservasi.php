<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';
    protected $fillable = [
        'user_id',
        'wisata_id',
        'tanggal_reservasi',
        'jumlah_orang',
        'total_harga',
        'status',
        'catatan',
    ];

    // Cast attributes
    protected $casts = [
        'tanggal_reservasi' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wisata()
    {
        return $this->belongsTo(Wisata::class);
    }
}
