<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'destination_id',
        'reservation_date',
        'quantity',
        'total_price',
        'status',
        'notes',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Relationship with StatusHistory
     */
    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class)->orderBy('created_at', 'desc');
    }
}
