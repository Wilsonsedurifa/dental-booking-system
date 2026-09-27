<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->with(['dentist.user', 'service'])
            ->latest('scheduled_at')
            ->paginate(10);

        return view('patient.my-appointments', compact('appointments'));
    }

    public function cancel(Appointment $appointment)
    {
        if ($appointment->patient_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return back()->with('error', 'This appointment cannot be cancelled because it is already ' . $appointment->status . '.');
        }

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Your appointment has been cancelled successfully.');
    }
}
