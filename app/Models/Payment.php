<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $fillable = ['booking_id', 'order_id', 'payment_method',
     'transaction_time', 'transaction_status', 'gross_amount', 'va_numbers', 
     'pdf_url'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
}
