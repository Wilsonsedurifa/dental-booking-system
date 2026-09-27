@extends('admin.layout')

@section('title', 'Manage Services - DentalCare')
@section('page_title', 'Dental Services')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <p style="color: #64748b; margin: 0;">Manage dental services, prices, and session durations.</p>
    <a href="{{ route('admin.services.create') }}" class="btn-admin-primary">+ Add New Service</a>
</div>

<div class="data-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service Name</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Appointments Booked</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $s)
                    <tr>
                        <td>#{{ $s->id }}</td>
                        <td>
                            <strong>{{ $s->name }}</strong>
                            <div style="font-size: 0.85rem; color: #64748b;">{{ Str::limit($s->description, 60) }}</div>
                        </td>
                        <td>{{ $s->duration_minutes }} minutes</td>
                        <td><strong style="color: #0f766e;">₱{{ number_format($s->price, 2) }}</strong></td>
                        <td>{{ $s->appointments_count }} bookings</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.services.edit', $s) }}" class="btn-admin-sm btn-admin-edit">Edit</a>
                                <form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Delete this dental service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-admin-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 2rem;">No services registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 1.5rem;">
    {{ $services->links() }}
</div>
@endsection