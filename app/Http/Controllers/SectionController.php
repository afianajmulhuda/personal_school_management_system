<?php

namespace App\Http\Controllers;

use App\Models\Sections;
use App\Models\Campus;
use App\Models\Classes;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        // Eager load relationships to prevent N+1 query execution problems
        $sections = Sections::with(['campus', 'classes'])->orderBy('campus_id')->orderBy('class_id')->get();
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        $campuses = Campus::all();
        $classes =Classes::all(); // Make sure this matches your model
        return view('sections.create', compact('campuses', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'campus_id' => 'required|exists:campuses,id',
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'room_number' => 'nullable|string|max:20',
        ]);

        Sections ::create($validated);

        return redirect()->route('sections.index')->with('success', 'Section/Class Track generated successfully.');
    }

    public function edit(Sections $section)
    {
        $campuses = Campus::all();
        $classes = Classes::all();
        return view('sections.edit', compact('section', 'campuses', 'classes'));
    }

    public function update(Request $request, Sections $section)
    {
        $validated = $request->validate([
            'campus_id' => 'required|exists:campuses,id',
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'room_number' => 'nullable|string|max:20',
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')->with('success', 'Section structural modifications compiled.');
    }

    public function destroy(Sections $section)
    {
        // Cascade delete on configurations will run automatically due to your migrations constraint
        $section->delete();
        return redirect()->route('sections.index')->with('success', 'Section dropped from the database cluster.');
    }
}