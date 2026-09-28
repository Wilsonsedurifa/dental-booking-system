@extends('admin.layout')

@section('title', 'Add Dentist - DentalCare')
@section('page_title', 'Add New Dentist Profile')

@section('content')
<div class="form-card">
    @if (isset($errors) && $errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.dentists.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Doctor's Full Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Maria Santos" required>
        </div>

        <div class="form-group">
            <label for="email">Clinic Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. dr.santos@dental.com" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Contact (Optional)</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. 09181234567">
        </div>

        <div class="form-group">
            <label for="specialization">Specialization / Expertise</label>
            <input type="text" id="specialization" name="specialization" class="form-control" value="{{ old('specialization') }}" placeholder="e.g. Orthodontics & Braces, Pediatric Dentistry, Oral Surgery" required>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center; margin-top: 2rem;">
            <button type="submit" class="btn-admin-primary">Create Dentist Profile</button>
            <a href="{{ route('admin.dentists.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection