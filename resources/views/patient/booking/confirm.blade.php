@extends('layouts.app')

@section('title', 'Confirm Appointment - DentalCare Clinic')

@section('content')
<div class="wizard-stepper">
    <div class="step-item completed">
        <span class="step-num">✓</span>
        <span class="step-title">Service</span>
    </div>
    <div class="step-item completed">
        <span class="step-num">✓</span>
        <span class="step-title">Dentist</span>
    </div>
    <div class="step-item completed">
        <span class="step-num">✓</span>
        <span class="step-title">Date & Time</span>
    </div>
    <div class="step-item active">
        <span class="step-num">4</span>
        <span class="step-title">Confirm</span>
    </div>
</div>

<div class="page-header">
    <h1>Confirm Your Appointment</h1>
    <p>Please review your booking details below before finalizing your schedule.</p>
</div>

@if (isset($errors) && $errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form action="{{ route('booking.store') }}" method="POST">
    @csrf
    <input type="hidden" name="service_id" value="{{ $service->id }}">
    <input type="hidden" name="dentist_id" value="{{ $dentist->id }}">
    <input type="hidden" name="appointment_date" value="{{ $date }}">
    <input type="hidden" name="appointment_time" value="{{ $time }}">

    <div class="summary-box">
        <div class="summary-row">
            <span class="summary-label">Patient Name:</span>
            <span class="summary-val">{{ Auth::user()->name }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Patient Contact:</span>
            <span class="summary-val">{{ Auth::user()->email }} {{ Auth::user()->phone ? '('.Auth::user()->phone.')' : '' }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Dental Service:</span>
            <span class="summary-val">{{ $service->name }} ({{ $service->duration_minutes }} mins)</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Attending Dentist:</span>
            <span class="summary-val">Dr. {{ $dentist->user->name ?? $dentist->name }} ({{ $dentist->specialization ?? 'General Dentist' }})</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Date & Time:</span>
            <span class="summary-val">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($time)->format('h:i A') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Service Fee:</span>
            <span class="summary-val" style="color: #0f766e; font-size: 1.25rem;">₱{{ number_format($service->price, 2) }}</span>
        </div>

        <div style="margin-top: 1.5rem;">
            <label for="notes" style="display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem;">Additional Notes or Concerns (Optional):</label>
            <textarea id="notes" name="notes" rows="3" style="width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-family: inherit;" placeholder="e.g. Tooth sensitivity on lower right molar, anxiety with needles, etc.">{{ old('notes') }}</textarea>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('booking.datetime') }}" class="nav-btn btn-secondary">&larr; Back to Date & Time</a>
        <button type="submit" class="btn-primary" style="padding: 1rem 2rem; font-size: 1.05rem;">Confirm & Book Appointment</button>
    </div>
</form>
@endsection