<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dentist;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentManagementController extends Controller
{
    public function dashboard()
    {
        $today = Carbon::today()->toDateString();

        $stats = [
            'total_appointments' => Appointment::count(),
            'scheduled_appointments' => Appointment::where('status', 'scheduled')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'total_dentists' => Dentist::count(),
            'total_patients' => User::where('role', 'patient')->count(),
        ];

        $todayAppointments = Appointment::with(['patient', 'dentist.user', 'service'])
            ->whereDate('scheduled_at', $today)
            ->orderBy('scheduled_at')
            ->get();

        $recentAppointments = Appointment::with(['patient', 'dentist.user', 'service'])
            ->latest('scheduled_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'todayAppointments', 'recentAppointments'));
    }

    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'dentist.user', 'service'])->latest('scheduled_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('scheduled_at', $request->date);
        }

        if ($request->filled('dentist_id')) {
            $query->where('dentist_id', $request->dentist_id);
        }

        $appointments = $query->paginate(15)->withQueryString();
        $dentists = Dentist::with('user')->get();

        return view('admin.appointments.index', compact('appointments', 'dentists'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'dentist.user', 'service']);
        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:scheduled,confirmed,completed,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $appointment->update($validated);

        return back()->with('success', "Appointment #{$appointment->id} status updated to {$validated['status']}.");
    }
}
