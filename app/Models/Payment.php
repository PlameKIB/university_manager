<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'enrollment_id',
        'receipt_number',
        'payment_date',
        'total_amount',
        'note',
    ];
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
