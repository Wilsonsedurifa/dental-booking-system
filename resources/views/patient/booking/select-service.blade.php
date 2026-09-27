@extends('layouts.app')

@section('title', 'Select Dental Service - DentalCare Clinic')

@section('content')
<div class="wizard-stepper">
    <div class="step-item active">
        <span class="step-num">1</span>
        <span class="step-title">Select Service</span>
    </div>
    <div class="step-item">
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
    <h1>Select a Dental Service</h1>
    <p>Choose the treatment or check-up service you require for your appointment.</p>
</div>

@if ($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
@endif

<form action="{{ route('booking.post-service') }}" method="POST">
    @csrf
    <div class="services-grid">
        @forelse ($services as $service)
            <label class="selection-card {{ $selectedServiceId == $service->id ? 'selected' : '' }}" onclick="selectServiceCard(this)">
                <input type="radio" name="service_id" value="{{ $service->id }}" {{ $selectedServiceId == $service->id ? 'checked' : '' }} style="position: absolute; opacity: 0;" required>
                <div>
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->description ?? 'Comprehensive dental care provided by certified professionals.' }}</p>
                </div>
                <div class="card-meta">
                    <span class="duration-tag">⏱ {{ $service->duration_minutes }} mins</span>
                    <span class="price-tag">₱{{ number_format($service->price, 2) }}</span>
                </div>
            </label>
        @empty
            <p>No dental services available at the moment. Please contact clinic admin.</p>
        @endforelse
    </div>

    <div class="form-actions" style="justify-content: flex-end;">
        <button type="submit" class="btn-primary">Next: Choose Dentist &rarr;</button>
    </div>
</form>

<script>
    function selectServiceCard(element) {
        document.querySelectorAll('.selection-card').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        element.querySelector('input[type="radio"]').checked = true;
    }
</script>
@endsection