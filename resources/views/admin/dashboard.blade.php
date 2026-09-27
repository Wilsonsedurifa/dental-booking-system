@extends('admin.layout')

@section('title', 'Admin Dashboard - DentalCare')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="metrics-grid">
    <div class="metric-card">
        <span class="metric-label">Total Appointments</span>
        <span class="metric-value">{{ $stats['total_appointments'] }}</span>
    </div>
    <div class="metric-card">
        <span class="metric-label">Scheduled / Pending</span>
        <span class="metric-value" style="color: #0284c7;">{{ $stats['scheduled_appointments'] }}</span>
    </div>
    <div class="metric-card">
        <span class="metric-label">Completed Sessions</span>
        <span class="metric-value" style="color: #16a34a;">{{ $stats['completed_appointments'] }}</span>
    </div>
    <div class="metric-card">
        <span class="metric-label">Active Dentists</span>
        <span class="metric-value">{{ $stats['total_dentists'] }}</span>
    </div>
    <div class="metric-card">
        <span class="metric-label">Registered Patients</span>
        <span class="metric-value">{{ $stats['total_patients'] }}</span>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h2 class="data-card-title">Today's Scheduled Appointments</h2>
        <a href="{{ route('admin.appointments.index') }}" class="btn-admin-sm btn-admin-view">View All &rarr;</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Patient</th>
                    <th>Dentist</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($todayAppointments as $app)
                    <tr>
                        <td><strong>{{ $app->scheduled_at->format('h:i A') }}</strong></td>
                        <td>{{ $app->patient->name ?? 'Patient' }}</td>
                        <td>Dr. {{ $app->dentist->user->name ?? $app->dentist->name ?? 'Dentist' }}</td>
                        <td>{{ $app->service->name ?? 'Dental Service' }}</td>
                        <td><span class="badge badge-{{ $app->status }}">{{ $app->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.appointments.show', $app) }}" class="btn-admin-sm btn-admin-view">Manage</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 2rem;">No appointments scheduled for today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="data-card">
    <div class="data-card-header">
        <h2 class="data-card-title">Recent Bookings</h2>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date & Time</th>
                    <th>Patient</th>
                    <th>Dentist</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentAppointments as $app)
                    <tr>
                        <td>#{{ $app->id }}</td>
                        <td>{{ $app->scheduled_at->format('M d, Y h:i A') }}</td>
                        <td>{{ $app->patient->name ?? 'Patient' }}</td>
                        <td>Dr. {{ $app->dentist->user->name ?? $app->dentist->name ?? 'Dentist' }}</td>
                        <td>{{ $app->service->name ?? 'Dental Service' }}</td>
                        <td><span class="badge badge-{{ $app->status }}">{{ $app->status }}</span></td>
                        <td>
                            <a href="{{ route('admin.appointments.show', $app) }}" class="btn-admin-sm btn-admin-view">Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94a3b8; padding: 2rem;">No appointments booked yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection