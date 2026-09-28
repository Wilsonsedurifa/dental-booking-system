<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DentalCare Clinic | Book your dental visit online</title>
    <meta name="description" content="Book, reschedule and track dental appointments online. Patients book in minutes; clinic staff manage the day from one dashboard.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

<header class="nav">
    <a href="{{ url('/') }}" class="brand">
        <span class="brand-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M7.5 3C5 3 3.5 5 3.5 7.5c0 2 .8 3.4 1.3 5.2.5 2 .6 5.3 1.9 7.3.5.8 1.5.8 1.9 0 .7-1.4.9-3.5 1.7-4.2.5-.4 1.1-.4 1.6 0 .8.7 1 2.8 1.7 4.2.4.8 1.4.8 1.9 0 1.3-2 1.4-5.3 1.9-7.3.5-1.8 1.3-3.2 1.3-5.2C20.7 5 19.2 3 16.7 3c-1.7 0-2.9.9-4.6.9S9.2 3 7.5 3z"/></svg>
        </span>
        DentalCare Clinic
    </a>
    <nav class="nav-links" aria-label="Main">
        <a href="#who">Patients &amp; staff</a>
        <a href="#steps">How it works</a>
        <a href="{{ route('login') }}" class="btn btn-ghost">Log in</a>
    </nav>
</header>

<main>
    <section class="hero">
        <div class="hero-copy">
            <h1>Your next dental visit, booked before your coffee cools.</h1>
            <p class="lead">Pick a service, choose a time that fits your day, and get confirmation right away. No calls, no waiting on hold.</p>
            <div class="cta-row">
                <a href="{{ route('register') }}" class="btn btn-primary">Book an appointment</a>
                <a href="{{ route('login') }}" class="btn btn-outline">I already have an account</a>
            </div>
            <p class="fine">Clinic staff? <a href="{{ route('login') }}">Log in to the dashboard</a></p>
        </div>

        <form class="slot-card" aria-label="Sample appointment picker" onsubmit="return false">
            <div class="slot-head">
                <strong>Teeth cleaning</strong>
                <span>45 min</span>
            </div>

            <fieldset class="days">
                <legend class="sr">Choose a day</legend>
                <label><input type="radio" name="day" checked><span><small>Mon</small>28</span></label>
                <label><input type="radio" name="day"><span><small>Tue</small>29</span></label>
                <label><input type="radio" name="day"><span><small>Wed</small>30</span></label>
                <label><input type="radio" name="day"><span><small>Thu</small>1</span></label>
                <label><input type="radio" name="day"><span><small>Fri</small>2</span></label>
            </fieldset>

            <fieldset class="slots">
                <legend class="sr">Choose a time</legend>
                <label><input type="radio" name="time"><span>9:00 AM</span></label>
                <label class="taken"><input type="radio" name="time" disabled><span>9:45 AM</span></label>
                <label><input type="radio" name="time" checked><span>10:30 AM</span></label>
                <label><input type="radio" name="time"><span>1:00 PM</span></label>
                <label class="taken"><input type="radio" name="time" disabled><span>1:45 PM</span></label>
                <label><input type="radio" name="time"><span>3:30 PM</span></label>
            </fieldset>

            <p class="slot-note">Greyed-out times are already taken. Try one, this is how booking works.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-block">Confirm this slot</a>
        </form>
    </section>

    <section class="who" id="who">
        <h2>One clinic, two ways in</h2>
        <div class="who-grid">
            <article class="panel panel-patient">
                <h3>For patients</h3>
                <p>Everything about your visits in one place.</p>
                <ul>
                    <li>Book, reschedule or cancel online</li>
                    <li>See upcoming and past appointments</li>
                    <li>Get a confirmation for every booking</li>
                </ul>
                <a href="{{ route('register') }}" class="btn btn-primary">Create patient account</a>
            </article>

            <article class="panel panel-admin">
                <h3>For clinic staff</h3>
                <p>Run the day without the paper diary.</p>
                <ul>
                    <li>See today's schedule at a glance</li>
                    <li>Approve, move or cancel appointments</li>
                    <li>Manage patients and services</li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-light">Log in to dashboard</a>
            </article>
        </div>
    </section>

    <section class="steps" id="steps">
        <h2>Booking takes three steps</h2>
        <ol>
            <li><b>Choose a service.</b> Cleaning, check-up, filling or anything else the clinic offers.</li>
            <li><b>Pick a time.</b> Only open slots are shown, so you never double-book.</li>
            <li><b>Show up.</b> Your appointment appears in your account, and staff see it instantly.</li>
        </ol>
    </section>
</main>

<footer class="foot">
    <p>Ready for a healthier smile?</p>
    <a href="{{ route('register') }}" class="btn btn-light">Book an appointment</a>
    <small>&copy; {{ date('Y') }} DentalCare Clinic</small>
</footer>

</body>
</html>