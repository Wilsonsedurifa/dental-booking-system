@extends('admin.layout')

@section('title', 'Manage Appointments - DentalCare')
@section('page_title', 'All Appointments')

@section('content')
<div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.25rem; margin-bottom: 2rem; display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
    <form method="GET" action="{{ route('admin.appointments.index') }}" style="display: flex; gap: 1rem; flex-wrap: wrap; width: 100%; align-items: center;">
        <div>
            <label style="font-size: 0.85rem; font-weight: 700; color: #64748b;">Status:</label>
            <select name="status" class="form-control" style="padding: 0.5rem 0.75rem; width: auto; display: inline-block;">
                <option value="">All Statuses</option>
                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div>
            <label style="font-size: 0.85rem; font-weight: 700; color: #64748b;">Date:</label>
            <input type="date" name="date" value="{{ request('date') }}" class="form-control" style="padding: 0.5rem 0.75rem; width: auto; display: inline-block;">
        </div>

        <div>
            <label style="font-size: 0.85rem; font-weight: 700; color: #64748b;">Dentist:</label>
            <select name="dentist_id" class="form-control" style="padding: 0.5rem 0.75rem; width: auto; display: inline-block;">
                <option value="">All Dentists</option>
                @foreach ($dentists as $d)
                    <option value="{{ $d->id }}" {{ request('dentist_id') == $d->id ? 'selected' : '' }}>Dr. {{ $d->user->name ?? $d->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn-admin-primary" style="padding: 0.5rem 1rem;">Filter</button>
        <a href="{{ route('admin.appointments.index') }}" class="btn-admin-sm btn-admin-view" style="padding: 0.5rem 0.85rem;">Reset</a>
    </form>
</div>

<div class="data-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Schedule</th>
                    <th>Patient</th>
                    <th>Dentist</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $app)
                    <tr>
                        <td>#{{ $app->id }}</td>
                        <td>
                            <div>{{ $app->scheduled_at->format('M d, Y') }}</div>
                            <div style="font-size: 0.8rem; color: #64748b;">{{ $app->scheduled_at->format('h:i A') }}</div>
                        </td>
                        <td>
                            <div>{{ $app->patient->name ?? 'N/A' }}</div>
                            <div style="font-size: 0.8rem; color: #64748b;">{{ $app->patient->email ?? '' }}</div>
                        </td>
                        <td>Dr. {{ $app->dentist->user->name ?? $app->dentist->name ?? 'Dentist' }}</td>
                        <td>{{ $app->service->name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($app->service->price ?? 0, 2) }}</td>
                        <td><span class="badge badge-{{ $app->status }}">{{ $app->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.appointments.show', $app) }}" class="btn-admin-sm btn-admin-view">Manage</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: #94a3b8; padding: 2rem;">No appointments matched the criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 1.5rem;">
    {{ $appointments->links() }}
</div>
@endsection