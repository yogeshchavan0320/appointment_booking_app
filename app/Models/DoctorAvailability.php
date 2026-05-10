<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'available_date',
        'start_time',
        'end_time',
        'slot_duration'
    ];

    // Doctor relation.
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
