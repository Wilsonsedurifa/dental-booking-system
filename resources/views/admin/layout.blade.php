<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel - DentalCare Clinic')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <span>🦷</span> DentalCare Admin
        </div>

        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                📊 Dashboard
            </a>
            <a href="{{ route('admin.appointments.index') }}" class="admin-nav-item {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                📅 Appointments
            </a>
            <a href="{{ route('admin.dentists.index') }}" class="admin-nav-item {{ request()->routeIs('admin.dentists.*') ? 'active' : '' }}">
                👨‍⚕️ Dentists
            </a>
            <a href="{{ route('admin.services.index') }}" class="admin-nav-item {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                🪥 Services
            </a>
            <a href="{{ route('booking.service') }}" class="admin-nav-item">
                🌐 Booking Portal
            </a>
        </nav>

        <div class="admin-logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="background: none; border: none; color: #ef4444; font-weight: 700; cursor: pointer; padding: 0.5rem; display: flex; align-items: center; gap: 0.5rem; font-family: inherit;">
                    🚪 Log Out
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <strong style="color: #0f172a; font-size: 1.1rem;">@yield('page_title', 'Dashboard Overview')</strong>
            </div>
            <div style="font-size: 0.9rem; color: #64748b;">
                Admin: <strong>{{ Auth::user()->name }}</strong>
            </div>
        </header>

        <main class="admin-content">
            @if (session('success'))
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.95rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.95rem;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>