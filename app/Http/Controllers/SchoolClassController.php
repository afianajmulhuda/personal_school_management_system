<?php

namespace App\Http\Controllers;

use App\Models\classes;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = classes::with('nextClass')->orderBy('numeric_level', 'asc')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $classes = classes::orderBy('numeric_level', 'asc')->get();
        return view('classes.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:classes,name',
            'numeric_level' => 'required|integer|unique:classes,numeric_level',
            'next_class_id' => 'nullable|exists:classes,id',
        ]);

        classes::create($validated);

        return redirect()->route('classes.index')->with('success', 'Class standard level launched successfully.');
    }

    public function edit($id)
    {
        $schoolClass = classes::findOrFail($id);
        // Exclude current record item from next class selection dropdown to prevent loop errors
        $availableClasses = classes::where('id', '!=', $id)->orderBy('numeric_level', 'asc')->get();
        
        return view('classes.edit', compact('schoolClass', 'availableClasses'));
    }

    public function update(Request $request, $id)
    {
        $schoolClass = classes::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:classes,name,' . $schoolClass->id,
            'numeric_level' => 'required|integer|unique:classes,numeric_level,' . $schoolClass->id,
            'next_class_id' => 'nullable|exists:classes,id|not_in:' . $schoolClass->id,
        ]);

        $schoolClass->update($validated);

        return redirect()->route('classes.index')->with('success', 'Class tracking configurations updated.');
    }

    public function destroy($id)
    {
        $schoolClass = classes::findOrFail($id);
        
        // Prevent action if dependency relations contain attached tracks
        if ($schoolClass->sections()->count() > 0) {
            return redirect()->back()->withErrors('Deletion aborted! Active campus section configurations are currently mapped to this class level.');
        }

        $schoolClass->delete();
        return redirect()->route('classes.index')->with('success', 'Academic level successfully detached.');
    }
}