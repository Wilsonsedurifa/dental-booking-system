<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in - DentalCare Clinic</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="aside">
    <div class="logo">
        <span class="logo-mark">🦷</span>
        DentalCare Clinic
    </div>
    <div>
        <h2>Welcome back.</h2>
        <p>Log in to manage your appointments, book your next dental visit, or access the clinic administrative dashboard.</p>
    </div>
</div>

<main>
    <div class="card">
        <h1>Log in</h1>
        <p class="sub">Enter your email and password to continue.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if (session('status'))
                <div class="notice" role="status">{{ session('status') }}</div>
            @endif

            @if (session('success'))
                <div class="notice" role="status">{{ session('success') }}</div>
            @endif

            @if (isset($errors) && $errors->any())
                <div class="error" role="alert">{{ $errors->first() }}</div>
            @endif

            <div class="field">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                    <button type="button" class="toggle" id="toggle" aria-controls="password" aria-pressed="false">Show</button>
                </div>
            </div>

            <div class="row">
                <label class="check"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Keep me logged in</label>
            </div>

            <button type="submit" class="btn">Log in</button>
        </form>

        <p class="foot">Don't have an account? <a href="{{ route('register') }}">Create patient account</a></p>
    </div>
</main>

<script>
    var pw = document.getElementById('password');
    var toggle = document.getElementById('toggle');
    if (pw && toggle) {
        toggle.addEventListener('click', function () {
            var show = pw.type === 'password';
            pw.type = show ? 'text' : 'password';
            toggle.textContent = show ? 'Hide' : 'Show';
            toggle.setAttribute('aria-pressed', show);
        });
    }
</script>
</body>
</html>