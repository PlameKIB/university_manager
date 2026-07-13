<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'promotion_id',
        'academic_year_id',
        'name',
        'amount',
    ];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
