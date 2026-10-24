<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subjects::orderBy('code', 'asc')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code',
            'is_elective' => 'nullable|boolean',
        ]);

        $validated['is_elective'] = $request->has('is_elective');

        Subjects::create($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject curriculum node added successfully.');
    }

    public function edit(Subjects $subject)
    {
        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subjects $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:subjects,code,' . $subject->id,
            'is_elective' => 'nullable|boolean',
        ]);

        $validated['is_elective'] = $request->has('is_elective');

        $subject->update($validated);

        return redirect()->route('subjects.index')->with('success', 'Subject course structure modified.');
    }

    public function destroy(Subjects $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject successfully purged from curriculum registry.');
    }
}