<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Exception;
use Carbon\Carbon;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BookAppointmentRequest;
use App\Notifications\AppointmentBookedNotification;

class DoctorAppointmentController extends Controller
{
    // View available slots.
    public function availableSlots(Doctor $doctor) {
        $availabilities = $doctor->availabilities;
        $slots = [];

        foreach ($availabilities as $availability) {
            $start = Carbon::parse($availability->start_time);
            $end = Carbon::parse($availability->end_time);

            while ($start < $end) {
                $slotEnd = $start->copy()
                    ->addMinutes(
                        $availability->slot_duration
                    );

                if ($slotEnd > $end) {
                    break;
                }

                $booked = Appointment::where([
                    'doctor_id' => $doctor->id,
                    'appointment_date' => $availability->available_date,
                    'start_time' => $start->format('H:i:s'),
                    'status' => 'booked'
                ])->exists();

                if (!$booked) {
                    $slots[] = [
                        'date' => $availability->available_date,
                        'start_time' => $start->format('H:i'),
                        'end_time' => $slotEnd->format('H:i')
                    ];
                }

                $start->addMinutes($availability->slot_duration);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $slots
        ]);
    }

    // Book appointment.
    public function book(BookAppointmentRequest $request, Doctor $doctor) {
        DB::beginTransaction();
        try {
            // Lock row for concurrency protection
            $exists = Appointment::where([
                'doctor_id' => $doctor->id,
                'appointment_date' => $request->appointment_date,
                'start_time' => $request->start_time,
                'status' => 'booked'
            ])
            ->lockForUpdate()
            ->exists();

            if ($exists) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Slot already booked'
                ], 422);
            }

            $appointment = Appointment::create([
                'doctor_id' => $doctor->id,
                'patient_name' => $request->patient_name,
                'patient_email' => $request->patient_email,
                'appointment_date' => $request->appointment_date,
                'start_time' => $request->start_time,
                'end_time' => Carbon::parse($request->start_time)->addMinutes(30)->format('H:i:s'),
                'booking_reference' => strtoupper(Str::random(10)),
                'status' => 'booked'
            ]);

            DB::commit();

            // send notification & added into queue
            $doctor->notify(
                new AppointmentBookedNotification(
                    $appointment
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully',
                'data' => $appointment
            ], 201);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Cancel appointment.
    public function cancel(Request $request, Appointment $appointment) {
        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->reason
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment cancelled successfully'
        ]);
    }

    // Reschedule appointment.
    public function reschedule( Request $request, Appointment $appointment) {
        $exists = Appointment::where([
            'doctor_id' => $appointment->doctor_id,
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'status' => 'booked'
        ])->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'New slot already booked'
            ], 422);
        }

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'start_time' => $request->start_time,
            'end_time' => Carbon::parse($request->start_time)->addMinutes(30)->format('H:i:s')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment rescheduled successfully',
            'data' => $appointment
        ]);
    }
}
