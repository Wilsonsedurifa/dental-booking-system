<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DentalCare Clinic - Modern Dental Booking System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('booking.service') }}" class="brand">
            <span>🦷</span> DentalCare Clinic
        </a>
        <div class="nav-links">
            <a href="{{ route('booking.service') }}" class="nav-btn">Book Appointment</a>
            <a href="{{ route('login') }}" class="nav-link">Log in</a>
            <a href="{{ route('register') }}" class="nav-btn btn-secondary">Sign Up</a>
        </div>
    </nav>

    <div class="container" style="text-align: center; padding: 4rem 1rem;">
        <h1 style="font-size: 2.75rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem;">
            Your Smile Deserves the Best Care.
        </h1>
        <p style="font-size: 1.2rem; color: #64748b; max-width: 600px; margin: 0 auto 2.5rem; line-height: 1.6;">
            Easy, convenient online booking for routine cleanings, braces, fillings, and dental consultations with accredited dentists.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <a href="{{ route('booking.service') }}" class="btn-primary" style="font-size: 1.1rem; padding: 1rem 2.25rem;">Book Appointment Now &rarr;</a>
            <a href="{{ route('login') }}" class="nav-btn btn-secondary" style="font-size: 1.1rem; padding: 1rem 2rem;">Log in to Account</a>
        </div>
    </div>
</body>
</html>