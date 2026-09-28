<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('make:admin {email?}', function (?string $email = null) {
    $email = $email ?: $this->ask('Enter admin email');
    
    $existing = User::where('email', $email)->first();
    if ($existing) {
        if ($this->confirm("User with email {$email} already exists. Promote to Admin?")) {
            $existing->update(['role' => 'admin']);
            $this->info("User {$email} is now an Administrator!");
            return 0;
        }
        return 0;
    }

    $name = $this->ask('Enter admin full name', 'Clinic Administrator');
    $password = $this->secret('Enter admin password (min 8 characters)') ?: 'password123';

    $user = User::create([
        'name' => $name,
        'email' => $email,
        'role' => 'admin',
        'password' => Hash::make($password),
    ]);

    $this->info("Admin account successfully created for {$user->email}!");
    return 0;
})->purpose('Create a new admin account or promote an existing user to admin');