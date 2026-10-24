<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\Campus;
use App\Models\Guardians; // Assuming Guardian model is present
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Students::with(['campus', 'guardian'])->orderBy('admission_no', 'asc')->get();
        // dd($students); // Debugging line to inspect the retrieved students
        return view('students.index', compact('students'));
    }

    public function create()
    {
        $campuses = Campus::all();
        $guardians = Guardians::orderBy('father_name', 'asc')->get(); // Adjust matching your actual structure
        // dd($guardians); // Debugging line to inspect the retrieved guardians
        return view('students.create', compact('campuses', 'guardians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admission_no' => 'required|string|max:50|unique:students,admission_no',
            'campus_id' => 'nullable|exists:campuses,id',
            'guardian_id' => 'required|exists:guardians,id',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:15',
            'blood_group' => 'nullable|string|max:5',
            'nationality' => 'required|string|max:50',
            'religion' => 'nullable|string|max:50',
            'student_phone' => 'nullable|string|max:20',
            'student_email' => 'nullable|email|max:100|unique:students,student_email',
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'registration_date' => 'required|date',
            'status' => 'required|string|in:ACTIVE,DROPPED,GRADUATED',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('students/photos', 'public');
            $validated['photo_url'] = Storage::url($path);
        }

        Students::create($validated);

        return redirect()->route('students.index')->with('success', 'Student registry file initialized successfully.');
    }

    public function edit($id)
    {
        $student = Students::findOrFail($id);
        $campuses = Campus::all();
        $guardians = Guardians::orderBy('father_name', 'asc')->get();
        return view('students.edit', compact('student', 'campuses', 'guardians'));
    }

    public function update(Request $request, $id)
    {
        $student = Students::findOrFail($id);

        $validated = $request->validate([
            'admission_no' => 'required|string|max:50|unique:students,admission_no,' . $student->id,
            'campus_id' => 'nullable|exists:campuses,id',
            'guardian_id' => 'required|exists:guardians,id',
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:15',
            'blood_group' => 'nullable|string|max:5',
            'nationality' => 'required|string|max:50',
            'religion' => 'nullable|string|max:50',
            'student_phone' => 'nullable|string|max:20',
            'student_email' => 'nullable|email|max:100|unique:students,student_email,' . $student->id,
            'current_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'registration_date' => 'required|date',
            'status' => 'required|string|in:ACTIVE,DROPPED,GRADUATED',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old asset trace if applicable
            if ($student->photo_url) {
                $oldPath = str_replace('/storage/', '', $student->photo_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('photo')->store('students/photos', 'public');
            $validated['photo_url'] = Storage::url($path);
        }

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student core ledger profile modifications finalized.');
    }

    public function destroy($id)
    {
        $student = Students::findOrFail($id);
        
        if ($student->photo_url) {
            $oldPath = str_replace('/storage/', '', $student->photo_url);
            Storage::disk('public')->delete($oldPath);
        }

        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student tracking metrics purged from the primary master tree.');
    }
}