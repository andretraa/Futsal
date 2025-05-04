<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_id',
        'tanggal_pemesanan',
        'start_time',
        'end_time',
        'status',
        'total_harga'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function payments()
    {
        return $this->hasOne(Payment::class);
    }
}
