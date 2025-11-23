<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'old_status',
        'new_status',
        'reason',
        'changed_by',
        'notes',
    ];

    /**
     * Relationship with Reservation
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
