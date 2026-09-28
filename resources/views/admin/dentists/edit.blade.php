@extends('admin.layout')

@section('title', 'Edit Dentist - DentalCare')
@section('page_title', 'Edit Dentist Profile')

@section('content')
<div class="form-card">
    @if (isset($errors) && $errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.dentists.update', $dentist) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Doctor's Full Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $dentist->user->name ?? $dentist->name) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Contact</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $dentist->user->phone ?? '') }}">
        </div>

        <div class="form-group">
            <label for="specialization">Specialization</label>
            <input type="text" id="specialization" name="specialization" class="form-control" value="{{ old('specialization', $dentist->specialization) }}" required>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center; margin-top: 2rem;">
            <button type="submit" class="btn-admin-primary">Update Profile</button>
            <a href="{{ route('admin.dentists.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection