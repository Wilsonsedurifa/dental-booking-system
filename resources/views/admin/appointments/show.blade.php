@extends('admin.layout')

@section('title', 'Appointment Details - DentalCare')
@section('page_title', 'Appointment #' . $appointment->id)

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; max-width: 900px;">
    <div class="form-card" style="max-width: 100%;">
        <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem; color: #0f172a;">Appointment Details</h3>

        <div style="margin-bottom: 1rem;">
            <span style="font-size: 0.85rem; color: #64748b; font-weight: 700; display: block;">Patient</span>
            <div style="font-size: 1.05rem; font-weight: 700; color: #0f172a;">{{ $appointment->patient->name ?? 'N/A' }}</div>
            <div style="font-size: 0.9rem; color: #64748b;">{{ $appointment->patient->email ?? '' }} | {{ $appointment->patient->phone ?? 'No phone' }}</div>
        </div>

        <div style="margin-bottom: 1rem;">
            <span style="font-size: 0.85rem; color: #64748b; font-weight: 700; display: block;">Service</span>
            <div style="font-size: 1.05rem; font-weight: 700; color: #0f172a;">{{ $appointment->service->name ?? 'N/A' }}</div>
            <div style="font-size: 0.9rem; color: #64748b;">Fee: ₱{{ number_format($appointment->service->price ?? 0, 2) }} ({{ $appointment->service->duration_minutes ?? 30 }} mins)</div>
        </div>

        <div style="margin-bottom: 1rem;">
            <span style="font-size: 0.85rem; color: #64748b; font-weight: 700; display: block;">Attending Dentist</span>
            <div style="font-size: 1.05rem; font-weight: 700; color: #0f172a;">Dr. {{ $appointment->dentist->user->name ?? $appointment->dentist->name ?? 'Dentist' }}</div>
            <div style="font-size: 0.9rem; color: #64748b;">Specialization: {{ $appointment->dentist->specialization ?? 'General Dentistry' }}</div>
        </div>

        <div style="margin-bottom: 1rem;">
            <span style="font-size: 0.85rem; color: #64748b; font-weight: 700; display: block;">Scheduled Date & Time</span>
            <div style="font-size: 1.05rem; font-weight: 700; color: #0284c7;">
                {{ $appointment->scheduled_at->format('l, F d, Y - h:i A') }}
            </div>
        </div>

        <div>
            <span style="font-size: 0.85rem; color: #64748b; font-weight: 700; display: block;">Patient Notes</span>
            <div style="font-size: 0.95rem; color: #334155; background: #f8fafc; padding: 0.75rem; border-radius: 6px; border: 1px solid #e2e8f0; margin-top: 0.25rem;">
                {{ $appointment->notes ?: 'No patient notes provided.' }}
            </div>
        </div>
    </div>

    <div class="form-card" style="max-width: 100%;">
        <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 1.5rem; color: #0f172a;">Update Status</h3>

        <form action="{{ route('admin.appointments.status', $appointment) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="status">Appointment Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="scheduled" {{ $appointment->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="form-group">
                <label for="admin_notes">Staff Notes (Optional)</label>
                <textarea name="notes" id="admin_notes" rows="4" class="form-control" placeholder="Add clinic follow-up remarks...">{{ $appointment->notes }}</textarea>
            </div>

            <button type="submit" class="btn-admin-primary" style="width: 100%;">Save Changes</button>
        </form>

        <div style="margin-top: 2rem;">
            <a href="{{ route('admin.appointments.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">&larr; Back to Appointments List</a>
        </div>
    </div>
</div>
@endsection