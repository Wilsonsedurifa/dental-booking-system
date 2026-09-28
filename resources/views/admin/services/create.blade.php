@extends('admin.layout')

@section('title', 'Add Service - DentalCare')
@section('page_title', 'Add Dental Service')

@section('content')
<div class="form-card">
    @if (isset($errors) && $errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Service Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Teeth Cleaning (Oral Prophylaxis)" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" class="form-control" placeholder="Brief explanation of the procedure...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price (PHP ₱)</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price', '1000.00') }}" required>
        </div>

        <div class="form-group">
            <label for="duration_minutes">Estimated Duration (Minutes)</label>
            <input type="number" id="duration_minutes" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', '45') }}" required>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center; margin-top: 2rem;">
            <button type="submit" class="btn-admin-primary">Create Service</button>
            <a href="{{ route('admin.services.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection