@extends('layouts.app')

@section('title', 'Select Date & Time - DentalCare Clinic')

@section('content')
<div class="wizard-stepper">
    <div class="step-item completed">
        <span class="step-num">✓</span>
        <span class="step-title">{{ $service->name }}</span>
    </div>
    <div class="step-item completed">
        <span class="step-num">✓</span>
        <span class="step-title">Dr. {{ $dentist->user->name ?? $dentist->name }}</span>
    </div>
    <div class="step-item active">
        <span class="step-num">3</span>
        <span class="step-title">Date & Time</span>
    </div>
    <div class="step-item">
        <span class="step-num">4</span>
        <span class="step-title">Confirm</span>
    </div>
</div>

<div class="page-header">
    <h1>Select Appointment Date & Time</h1>
    <p>Choose an available slot with Dr. {{ $dentist->user->name ?? $dentist->name }} for <strong>{{ $service->name }}</strong>.</p>
</div>

@if (isset($errors) && $errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form action="{{ route('booking.post-datetime') }}" method="POST">
    @csrf

    <div class="date-slot-wrapper">
        <div class="date-picker-group">
            <label for="appointment_date">Appointment Date:</label>
            <input type="date" id="appointment_date" name="appointment_date" class="date-input" value="{{ $selectedDate }}" min="{{ now()->addDay()->toDateString() }}" onchange="refreshDateSlots(this.value)" required>
            <p style="font-size: 0.85rem; color: #64748b; margin-top: 0.35rem;">Changing the date refreshes the available hourly slots.</p>
        </div>

        <div>
            <label style="display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem;">Available Time Slots:</label>
            <div class="slots-grid">
                @forelse ($timeSlots as $slot)
                    <div class="slot-item {{ $slot['is_booked'] ? 'booked' : '' }} {{ $selectedTime == $slot['time_24'] ? 'selected' : '' }}"
                         onclick="selectTimeSlot('{{ $slot['time_24'] }}', this, {{ $slot['is_booked'] ? 'true' : 'false' }})">
                        {{ $slot['time_12'] }}
                        @if ($slot['is_booked'])
                            <div style="font-size: 0.7rem; color: #94a3b8;">Booked</div>
                        @else
                            <div style="font-size: 0.7rem; color: #0d9488;">Available</div>
                        @endif
                    </div>
                @empty
                    <p>No available slots found for this date. Please pick another date.</p>
                @endforelse
            </div>
            <input type="hidden" name="appointment_time" id="appointment_time" value="{{ $selectedTime }}" required>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ route('booking.dentist') }}" class="nav-btn btn-secondary">&larr; Back to Dentists</a>
        <button type="submit" class="btn-primary" id="btn-next">Next: Review & Confirm &rarr;</button>
    </div>
</form>

<script>
    function selectTimeSlot(timeVal, element, isBooked) {
        if (isBooked) return;
        document.querySelectorAll('.slot-item').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('appointment_time').value = timeVal;
    }

    function refreshDateSlots(dateVal) {
        window.location.href = "{{ route('booking.datetime') }}?date=" + dateVal;
    }
</script>
@endsection