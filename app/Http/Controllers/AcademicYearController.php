<?php

namespace App\Http\Controllers;

use App\Models\AcademicYears;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYears::orderBy('start_date', 'desc')->get();
        return view('academic_years.index', compact('years'));
    }

    public function create()
    {
        return view('academic_years.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20|unique:academic_years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        // Standardize dynamic checkbox values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_closed'] = false; // Fresh terms default open

        DB::transaction(function () use ($validated) {
            // Guarantee exclusivity: If this entry is designated active, turn off all older ones
            if ($validated['is_active']) {
                AcademicYears::query()->update(['is_active' => false]);
            }
            AcademicYears::create($validated);
        });

        return redirect()->route('system.rolloverView')->with('success', 'Academic Year profile initialized successfully.');
    }

    public function edit($id)
    {
        $year = AcademicYears::findOrFail($id);
        return view('academic_years.edit', compact('year'));
    }

    public function update(Request $request, $id)
    {
        $year = AcademicYears::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:20|unique:academic_years,name,' . $year->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'nullable|boolean',
            'is_closed' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_closed'] = $request->has('is_closed');

        // Logic Safeguard: Closed target terms cannot remain marked active
        if ($validated['is_closed']) {
            $validated['is_active'] = false;
        }

        DB::transaction(function () use ($year, $validated) {
            if ($validated['is_active']) {
                AcademicYears::where('id', '!=', $year->id)->update(['is_active' => false]);
            }
            $year->update($validated);
        });

        return redirect()->route('system.rolloverView')->with('success', 'Academic Year tracking configuration changes committed.');
    }

    public function destroy($id)
    {
        $year = AcademicYears::findOrFail($id);

        // Core business constraint check: Do not allow deletion of an active operational tracking cycle
        if ($year->is_active) {
            return redirect()->back()->withErrors('Deletion aborted! Cannot purge an active cycle node from the database.');
        }

        $year->delete();
        return redirect()->route('system.rolloverView')->with('success', 'Academic calendar structure successfully purged.');
    }
}
