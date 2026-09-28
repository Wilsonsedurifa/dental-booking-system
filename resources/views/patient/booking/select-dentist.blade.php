@extends('layouts.app')

@section('title', 'Choose Dentist - DentalCare Clinic')

@section('content')
<div class="wizard-stepper">
    <div class="step-item completed">
        <span class="step-num">✓</span>
        <span class="step-title">{{ $service->name }}</span>
    </div>
    <div class="step-item active">
        <span class="step-num">2</span>
        <span class="step-title">Choose Dentist</span>
    </div>
    <div class="step-item">
        <span class="step-num">3</span>
        <span class="step-title">Date & Time</span>
    </div>
    <div class="step-item">
        <span class="step-num">4</span>
        <span class="step-title">Confirm</span>
    </div>
</div>

<div class="page-header">
    <h1>Select a Dentist</h1>
    <p>Pick one of our board-certified dental practitioners for your <strong>{{ $service->name }}</strong>.</p>
</div>

@if (isset($errors) && $errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form action="{{ route('booking.post-dentist') }}" method="POST">
    @csrf
    <div class="dentists-grid">
        @forelse ($dentists as $dentist)
            <label class="selection-card {{ $selectedDentistId == $dentist->id ? 'selected' : '' }}" onclick="selectDentistCard(this)">
                <input type="radio" name="dentist_id" value="{{ $dentist->id }}" {{ $selectedDentistId == $dentist->id ? 'checked' : '' }} style="position: absolute; opacity: 0;" required>
                <div>
                    <div style="font-size: 2.25rem; margin-bottom: 0.5rem;">👨‍⚕️</div>
                    <h3>Dr. {{ $dentist->user->name ?? $dentist->name }}</h3>
                    <p style="color: #0d9488; font-weight: 700; margin-bottom: 0.5rem;">{{ $dentist->specialization ?? 'General Dentistry' }}</p>
                    <p style="font-size: 0.85rem; color: #64748b;">Schedule: Mon - Sat (9:00 AM - 5:00 PM)</p>
                </div>
            </label>
        @empty
            <p>No dentists available currently. Please check back later.</p>
        @endforelse
    </div>

    <div class="form-actions">
        <a href="{{ route('booking.service') }}" class="nav-btn btn-secondary">&larr; Back to Services</a>
        <button type="submit" class="btn-primary">Next: Pick Date & Time &rarr;</button>
    </div>
</form>

<script>
    function selectDentistCard(element) {
        document.querySelectorAll('.selection-card').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        element.querySelector('input[type="radio"]').checked = true;
    }
</script>
@endsection