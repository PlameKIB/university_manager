<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     use LogsActivity;
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
