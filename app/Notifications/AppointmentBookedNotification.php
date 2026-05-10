<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentBookedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    // Create a new notification instance.
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    // Notification channels.
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    // Store notification in database.
    public function toDatabase(object $notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'Your Appointment booked successfully',
            'booking_reference' => $this->appointment->booking_reference,
            'appointment_date' => $this->appointment->appointment_date,
            'start_time' => $this->appointment->start_time,
        ];
    }

    // Send email notification.
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)

            ->subject('Appointment Booking Confirmation')

            ->greeting('Hello ' . $this->appointment->patient_name)

            ->line('Your appointment has been booked successfully.')

            ->line(
                'Booking Reference: '
                . $this->appointment->booking_reference
            )

            ->line(
                'Appointment Date: '
                . $this->appointment->appointment_date
            )

            ->line(
                'Appointment Time: '
                . $this->appointment->start_time
            )

            ->line('Thank you.');
    }

    // Get the array representation of the notification.
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
