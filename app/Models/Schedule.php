<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'field_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_available',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function bookings()
    {
        return $this->hasOne(Booking::class);
    }

    public function dashboard()
    {
        return $this->hasMany(Dashboard::class);
    }
}
