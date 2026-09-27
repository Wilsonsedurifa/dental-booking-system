@vite(['resources/css/login.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Log in - {{ config('app.name') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="aside">
  <div class="logo">
    <span class="logo-mark">
      <svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12l5 5L20 6"/></svg>
    </span>
    {{ config('app.name', 'Your App') }}
  </div>
  <div>
    <h2>Welcome back.</h2>
    <p>Log in to pick up where you left off.</p>
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

      @if ($errors->any())
        <div class="error show" role="alert">{{ $errors->first() }}</div>
      @endif

      <div class="field">
        <label for="email">Email</label>
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
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}">Forgot password?</a>
        @endif
      </div>

      <button type="submit" class="btn">Log in</button>
    </form>

    <p class="foot">Don't have an account? <a href="{{ route('register') }}">Create one</a></p>
  </div>
</main>

<script>
  var pw = document.getElementById('password');
  var toggle = document.getElementById('toggle');
  toggle.addEventListener('click', function () {
    var show = pw.type === 'password';
    pw.type = show ? 'text' : 'password';
    toggle.textContent = show ? 'Hide' : 'Show';
    toggle.setAttribute('aria-pressed', show);
  });
</script>
</body>
</html>
