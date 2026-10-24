<?php

namespace App\Http\Controllers;

use App\Models\Guardians;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function index()
    {
        $guardians = Guardians::withCount('students')->orderBy('id', 'desc')->get();
        return view('guardians.index', compact('guardians'));
    }

    public function create()
    {
        return view('guardians.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'father_name' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:20',
            'father_profession' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:20',
            'mother_profession' => 'nullable|string|max:100',
            'emergency_contact_name' => 'required|string|max:100',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_relation' => 'required|string|max:50',
            'guardian_email' => 'nullable|email|max:100',
            'residential_address' => 'required|string',
        ]);

        Guardians::create($validated);

        return redirect()->route('guardians.index')->with('success', 'Guardian record account created successfully.');
    }

    public function edit(Guardians $guardian)
    {
        return view('guardians.edit', compact('guardian'));
    }

    public function update(Request $request, Guardians $guardian)
    {
        $validated = $request->validate([
            'father_name' => 'nullable|string|max:100',
            'father_phone' => 'nullable|string|max:20',
            'father_profession' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'mother_phone' => 'nullable|string|max:20',
            'mother_profession' => 'nullable|string|max:100',
            'emergency_contact_name' => 'required|string|max:100',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_relation' => 'required|string|max:50',
            'guardian_email' => 'nullable|email|max:100',
            'residential_address' => 'required|string',
        ]);

        $guardian->update($validated);

        return redirect()->route('guardians.index')->with('success', 'Guardian file tracking information modified.');
    }

    public function destroy(Guardians $guardian)
    {
        // Enforce structural restriction programmatically before hitting database crash
        if ($guardian->students()->count() > 0) {
            return redirect()->back()->withErrors('Deletion Refused! This record is bounded to an active student admission log.');
        }

        $guardian->delete();
        return redirect()->route('guardians.index')->with('success', 'Guardian family matrix profile deleted.');
    }
}
