<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dentist;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Step 1: Select Dental Service
     */
    public function selectService(Request $request)
    {
        $services = Service::where('is_active', true)->orWhereNull('is_active')->orderBy('name')->get();
        $selectedServiceId = session('booking.service_id', $request->query('service_id'));

        return view('patient.booking.select-service', compact('services', 'selectedServiceId'));
    }

    public function postService(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
        ]);

        session(['booking.service_id' => $request->service_id]);

        return redirect()->route('booking.dentist');
    }

    /**
     * Step 2: Select Dentist
     */
    public function selectDentist(Request $request)
    {
        $serviceId = session('booking.service_id');
        if (! $serviceId) {
            return redirect()->route('booking.service')->with('error', 'Please choose a service first.');
        }

        $service = Service::findOrFail($serviceId);
        $dentists = Dentist::with('user')->get();
        $selectedDentistId = session('booking.dentist_id', $request->query('dentist_id'));

        return view('patient.booking.select-dentist', compact('service', 'dentists', 'selectedDentistId'));
    }

    public function postDentist(Request $request)
    {
        $request->validate([
            'dentist_id' => ['required', 'exists:dentists,id'],
        ]);

        session(['booking.dentist_id' => $request->dentist_id]);

        return redirect()->route('booking.datetime');
    }

    /**
     * Step 3: Select Date & Time
     */
    public function selectDateTime(Request $request)
    {
        $serviceId = session('booking.service_id');
        $dentistId = session('booking.dentist_id');

        if (! $serviceId || ! $dentistId) {
            return redirect()->route('booking.service')->with('error', 'Please complete previous steps first.');
        }

        $service = Service::findOrFail($serviceId);
        $dentist = Dentist::with('user')->findOrFail($dentistId);

        $selectedDate = session('booking.appointment_date', $request->query('date', Carbon::tomorrow()->toDateString()));
        $selectedTime = session('booking.appointment_time', $request->query('time'));

        // Generate available hourly slots from 9:00 AM to 5:00 PM
        $timeSlots = $this->generateTimeSlots($dentist, $selectedDate);

        return view('patient.booking.select-datetime', compact(
            'service',
            'dentist',
            'selectedDate',
            'selectedTime',
            'timeSlots'
        ));
    }

    public function postDateTime(Request $request)
    {
        $request->validate([
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'string'],
        ]);

        session([
            'booking.appointment_date' => $request->appointment_date,
            'booking.appointment_time' => $request->appointment_time,
        ]);

        return redirect()->route('booking.confirm');
    }

    /**
     * Step 4: Review and Confirm Booking
     */
    public function confirm()
    {
        $serviceId = session('booking.service_id');
        $dentistId = session('booking.dentist_id');
        $date = session('booking.appointment_date');
        $time = session('booking.appointment_time');

        if (! $serviceId || ! $dentistId || ! $date || ! $time) {
            return redirect()->route('booking.service')->with('error', 'Incomplete booking details.');
        }

        $service = Service::findOrFail($serviceId);
        $dentist = Dentist::with('user')->findOrFail($dentistId);

        return view('patient.booking.confirm', compact('service', 'dentist', 'date', 'time'));
    }

    /**
     * Store Confirmed Appointment
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'dentist_id' => ['required', 'exists:dentists,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'string'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $scheduledAt = Carbon::parse($request->appointment_date . ' ' . $request->appointment_time);

        // Anti double-booking validation
        $conflict = Appointment::where('dentist_id', $request->dentist_id)
            ->where('scheduled_at', $scheduledAt)
            ->whereIn('status', ['scheduled', 'pending', 'confirmed'])
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Sorry, this exact date and time slot was just taken. Please choose another time.')->withInput();
        }

        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
            'dentist_id' => $request->dentist_id,
            'service_id' => $request->service_id,
            'scheduled_at' => $scheduledAt,
            'status' => 'scheduled',
            'notes' => $request->notes,
        ]);

        // Clear session booking
        session()->forget('booking');

        return redirect()->route('patient.appointments')->with('success', "Appointment #{$appointment->id} successfully booked! Our clinic has received your schedule.");
    }

    /**
     * Helper to generate time slots (9 AM - 5 PM)
     */
    private function generateTimeSlots(Dentist $dentist, string $date): array
    {
        $slots = [];
        $start = Carbon::parse($date . ' 09:00:00');
        $end = Carbon::parse($date . ' 17:00:00');

        $bookedTimes = Appointment::where('dentist_id', $dentist->id)
            ->whereDate('scheduled_at', $date)
            ->whereIn('status', ['scheduled', 'pending', 'confirmed'])
            ->get()
            ->map(fn ($app) => $app->scheduled_at->format('H:i'))
            ->toArray();

        while ($start < $end) {
            $slotFormatted = $start->format('H:i');
            $labelFormatted = $start->format('h:i A');

            $isBooked = in_array($slotFormatted, $bookedTimes);

            $slots[] = [
                'time_24' => $slotFormatted,
                'time_12' => $labelFormatted,
                'is_booked' => $isBooked,
            ];

            $start->addMinutes(60);
        }

        return $slots;
    }
}
