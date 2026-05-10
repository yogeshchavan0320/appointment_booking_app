<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_name',
        'patient_email',
        'appointment_date',
        'start_time',
        'end_time',
        'booking_reference',
        'status',
        'cancellation_reason'
    ];

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }
}
