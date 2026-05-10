<?php

namespace App\Http\Controllers\Api;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\DoctorAvailability;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorAvailabilityRequest;

class DoctorAvailabilityController extends Controller
{
    // Store doctor availability.

    public function store(
        StoreDoctorAvailabilityRequest $request,
        Doctor $doctor
    ) {

        $data = $request->validated();

        // Check overlapping schedule
        $exists = DoctorAvailability::where('doctor_id', $doctor->id)
            ->where('available_date', $data['available_date'])
            ->where(function ($query) use ($data) {

                $query->whereBetween('start_time', [
                    $data['start_time'],
                    $data['end_time']
                ])

                ->orWhereBetween('end_time', [
                    $data['start_time'],
                    $data['end_time']
                ]);
            })
            ->exists();

        if ($exists) {

            return response()->json([
                'success' => false,
                'message' => 'Availability overlaps existing schedule'
            ], 422);
        }

        $availability = DoctorAvailability::create([
            'doctor_id' => $doctor->id,
            'available_date' => $data['available_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'slot_duration' => $data['slot_duration'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor availability created successfully',
            'data' => $availability
        ], 201);
    }

    // Get doctor availabilities.

    public function index(Doctor $doctor)
    {
        $availabilities = DoctorAvailability::where(
            'doctor_id',
            $doctor->id
        )->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $availabilities
        ]);
    }
}
