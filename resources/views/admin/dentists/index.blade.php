@extends('admin.layout')

@section('title', 'Manage Dentists - DentalCare')
@section('page_title', 'Dentists Directory')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <p style="color: #64748b; margin: 0;">Manage accredited clinic dentists and specialists.</p>
    <a href="{{ route('admin.dentists.create') }}" class="btn-admin-primary">+ Add New Dentist</a>
</div>

<div class="data-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Specialization</th>
                    <th>Total Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dentists as $d)
                    <tr>
                        <td>#{{ $d->id }}</td>
                        <td><strong>Dr. {{ $d->user->name ?? $d->name }}</strong></td>
                        <td>{{ $d->user->email ?? 'N/A' }}</td>
                        <td><span style="color: #0d9488; font-weight: 700;">{{ $d->specialization ?? 'General Dentist' }}</span></td>
                        <td>{{ $d->appointments_count }} appointments</td>
                        <td>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="{{ route('admin.dentists.edit', $d) }}" class="btn-admin-sm btn-admin-edit">Edit</a>
                                <form action="{{ route('admin.dentists.destroy', $d) }}" method="POST" onsubmit="return confirm('Delete this dentist?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-admin-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #94a3b8; padding: 2rem;">No dentists registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 1.5rem;">
    {{ $dentists->links() }}
</div>
@endsection