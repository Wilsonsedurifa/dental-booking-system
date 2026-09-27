@extends('admin.layout')

@section('title', 'Edit Service - DentalCare')
@section('page_title', 'Edit Dental Service')

@section('content')
<div class="form-card">
    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.9rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.services.update', $service) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Service Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3" class="form-control">{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price (PHP ₱)</label>
            <input type="number" step="0.01" id="price" name="price" class="form-control" value="{{ old('price', $service->price) }}" required>
        </div>

        <div class="form-group">
            <label for="duration_minutes">Estimated Duration (Minutes)</label>
            <input type="number" id="duration_minutes" name="duration_minutes" class="form-control" value="{{ old('duration_minutes', $service->duration_minutes) }}" required>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center; margin-top: 2rem;">
            <button type="submit" class="btn-admin-primary">Update Service</button>
            <a href="{{ route('admin.services.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">Cancel</a>
        </div>
    </form>
</div>
@endsection