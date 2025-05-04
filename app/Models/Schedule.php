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
}
