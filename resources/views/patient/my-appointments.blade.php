@extends('layouts.app')

@section('title', 'My Appointments - DentalCare Clinic')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1>My Dental Appointments</h1>
        <p>View your scheduled clinic sessions and history.</p>
    </div>
    <a href="{{ route('booking.service') }}" class="btn-primary" style="text-decoration: none;">+ Book New Appointment</a>
</div>

@if ($appointments->isEmpty())
    <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 3rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🗓</div>
        <h3 style="font-size: 1.25rem; color: #0f172a; margin-bottom: 0.5rem;">No appointments found</h3>
        <p style="color: #64748b; margin-bottom: 1.5rem;">You haven't scheduled any dental appointments yet.</p>
        <a href="{{ route('booking.service') }}" class="btn-primary" style="text-decoration: none;">Book Your First Appointment</a>
    </div>
@else
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Booking #</th>
                <th>Service</th>
                <th>Dentist</th>
                <th>Scheduled Date & Time</th>
                <th>Fee</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $app)
                <tr>
                    <td><strong>#{{ $app->id }}</strong></td>
                    <td>
                        <strong>{{ $app->service->name ?? 'General Dental' }}</strong>
                        <div style="font-size: 0.8rem; color: #64748b;">{{ $app->service->duration_minutes ?? 30 }} mins</div>
                    </td>
                    <td>Dr. {{ $app->dentist->user->name ?? $app->dentist->name ?? 'Attending Dentist' }}</td>
                    <td>
                        <div>📅 {{ $app->scheduled_at->format('M d, Y') }}</div>
                        <div style="font-size: 0.8rem; color: #64748b;">⏰ {{ $app->scheduled_at->format('h:i A') }}</div>
                    </td>
                    <td>₱{{ number_format($app->service->price ?? 0, 2) }}</td>
                    <td>
                        <span class="badge badge-{{ $app->status }}">{{ $app->status }}</span>
                    </td>
                    <td>
                        @if (in_array($app->status, ['scheduled', 'pending', 'confirmed']))
                            <form action="{{ route('patient.appointments.cancel', $app) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                @csrf
                                <button type="submit" class="btn-danger">Cancel</button>
                            </form>
                        @else
                            <span style="color: #94a3b8; font-size: 0.85rem;">Completed</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 1.5rem;">
        {{ $appointments->links() }}
    </div>
@endif
@endsection