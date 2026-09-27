<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'DentalCare Clinic - Appointment Booking')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('booking.service') }}" class="brand">
            <span>🦷</span> DentalCare Clinic
        </a>

        <div class="nav-links">
            <a href="{{ route('booking.service') }}" class="nav-link {{ request()->routeIs('booking.*') ? 'active' : '' }}">Book Appointment</a>
            @auth
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Dashboard</a>
                @else
                    <a href="{{ route('patient.appointments') }}" class="nav-link {{ request()->routeIs('patient.appointments') ? 'active' : '' }}">My Appointments</a>
                @endif
                <span style="color: #64748b; font-size: 0.875rem;">Hi, <strong>{{ Auth::user()->name }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-btn btn-secondary">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                <a href="{{ route('register') }}" class="nav-btn">Sign Up</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>