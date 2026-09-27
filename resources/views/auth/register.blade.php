@vite(['resources/css/login.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign up - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="aside">
    <div class="logo">
        <span class="logo-mark" style="background: #fff; border-radius: 8px; font-size: 1.25rem;">🦷</span>
        DentalCare Clinic
    </div>
    <div>
        <h2>Join Us Today.</h2>
        <p>Create your patient account to book appointments, consult with accredited dentists, and view your clinic records.</p>
    </div>
</div>

<main>
    <div class="card">
        <h1>Patient Registration</h1>
        <p class="sub">Create your account to start booking appointments.</p>

        @if ($errors->any())
            <div class="error show" role="alert">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @if ($errors->has('email') && str_contains($errors->first('email'), 'already been taken'))
                    <div style="margin-top: 0.5rem; font-weight: bold;">
                        Registered na ba ang email mo? <a href="{{ route('login') }}" style="text-decoration: underline; color: #fff;">Mag-Log in dito</a>
                    </div>
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="field">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Juan Dela Cruz" required autofocus>
            </div>

            <div class="field">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="e.g. juan@example.com" required>
            </div>

            <div class="field">
                <label for="phone">Phone Number (Optional)</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="e.g. 09171234567">
            </div>

            <div class="field">
                <label for="password">Password (Minimum 8 chars)</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Create Patient Account</button>
        </form>

        <p class="foot">Already have an account? <a href="{{ route('login') }}">Log in here</a></p>
    </div>
</main>
</body>
</html>
