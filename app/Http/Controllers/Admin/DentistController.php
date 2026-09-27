<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dentist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DentistController extends Controller
{
    public function index()
    {
        $dentists = Dentist::with('user')->withCount('appointments')->latest()->paginate(10);
        return view('admin.dentists.index', compact('dentists'));
    }

    public function create()
    {
        return view('admin.dentists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialization' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'dentist',
            'password' => Hash::make('password123'),
        ]);

        Dentist::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'],
        ]);

        return redirect()->route('admin.dentists.index')->with('success', 'Dentist profile created successfully. (Default password: password123)');
    }

    public function edit(Dentist $dentist)
    {
        $dentist->load('user');
        return view('admin.dentists.edit', compact('dentist'));
    }

    public function update(Request $request, Dentist $dentist)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'specialization' => ['required', 'string', 'max:255'],
        ]);

        if ($dentist->user) {
            $dentist->user->update([
                'name' => $validated['name'],
                'phone' => $validated['phone'] ?? null,
            ]);
        }

        $dentist->update([
            'specialization' => $validated['specialization'],
        ]);

        return redirect()->route('admin.dentists.index')->with('success', 'Dentist profile updated successfully.');
    }

    public function destroy(Dentist $dentist)
    {
        $dentist->delete();

        return redirect()->route('admin.dentists.index')->with('success', 'Dentist profile deleted successfully.');
    }
}
