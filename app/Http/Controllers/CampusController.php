<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use Illuminate\Http\Request;

class CampusController extends Controller
{
    public function index()
    {
        $campuses = Campus::withCount('enrollments')->get();
        return view('campuses.index', compact('campuses'));
    }

    public function create()
    {
        return view('campuses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:campuses,code',
            'address' => 'nullable|string'
        ]);

        Campus::create($validated);
        return redirect()->route('campuses.index')->with('success', 'Campus created successfully.');
    }

    public function edit(Campus $campus)
    {
        return view('campuses.edit', compact('campus'));
    }

    public function update(Request $request, Campus $campus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:10|unique:campuses,code,' . $campus->id,
            'address' => 'nullable|string'
        ]);

        $campus->update($validated);
        return redirect()->route('campuses.index')->with('success', 'Campus updated successfully.');
    }

    public function destroy(Campus $campus)
    {
        // Protected execution: Eloquent handles restricted cascades automatically
        $campus->delete();
        return redirect()->route('campuses.index')->with('success', 'Campus deleted safely.');
    }
}