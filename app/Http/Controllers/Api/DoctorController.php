<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Doctor;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;

class DoctorController extends Controller
{
    // Display all doctors.
    public function index() {
        $doctors = Doctor::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Doctor list retrieved successfully',
            'data' => $doctors
        ]);
    }

    // Store a new doctor.
    public function store(StoreDoctorRequest $request) {
        $doctor = Doctor::create([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'specialization' => $request->specialization,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor details created successfully',
            'data' => $doctor
        ], 201);
    }

    // Show single doctor.
    public function show(Doctor $doctor) {
        return response()->json([
            'success' => true,
            'message' => 'Doctor details fetched successfully',
            'data' => $doctor
        ]);
    }

    // Update doctor.
    public function update(UpdateDoctorRequest $request, Doctor $doctor) {
        $doctor->update([
            'name' => $request->name ?? $doctor->name,
            'mobile_no' => $request->mobile_no ?? $doctor->mobile_no,
            'specialization' => $request->specialization ?? $doctor->specialization,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor details updated successfully',
            'data' => $doctor
        ], 200);
    }

    // Delete doctor.
    public function destroy(Doctor $doctor) {
        $doctor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully'
        ]);
    }
}
