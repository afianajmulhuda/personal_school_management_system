<?php

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\Exams;
use App\Models\Student_Enrollments;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MarkController extends Controller
{
    public function index()
    {
        $marks = Marks::with(['exam', 'studentEnrollment.student','studentEnrollment.class', 'studentEnrollment.section'])
            ->orderBy('exam_id', 'desc')
            ->get();
        // dd($marks);
            
        return view('marks.index', compact('marks'));
    }

    public function create()
    {
        $exams = Exams::with(['examTerm', 'section', 'subject'])
            ->orderBy('id', 'desc')
            ->get();
        // dd($exams);
        $enrollments = Student_Enrollments::with(['student', 'class', 'section'])->get();
        // dd($enrollments);
        return view('marks.create', compact('exams', 'enrollments'));
    }

    public function store(Request $request)
    {
        $isAbsent = $request->has('is_absent');

        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_enrollment_id' => [
                'required',
                'exists:student_enrollments,id',
                // Enforce composite unique database rule at application layer
                Rule::unique('marks')->where(function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam_id);
                })
            ],
            'marks_obtained' => $isAbsent ? 'nullable|numeric|min:0|max:100' : 'required|numeric|min:0|max:100',
            'teacher_remarks' => 'nullable|string|max:500',
        ], [
            'student_enrollment_id.unique' => 'A grade record already exists for this student in the selected exam specification.'
        ]);

        Marks::create([
            'exam_id' => $request->exam_id,
            'student_enrollment_id' => $request->student_enrollment_id,
            'marks_obtained' => $isAbsent ? 0.00 : $request->marks_obtained,
            'is_absent' => $isAbsent,
            'teacher_remarks' => $request->teacher_remarks,
        ]);

        return redirect()->route('marks.index')->with('success', 'Student performance metrics logged successfully.');
    }

    public function edit(Marks $mark)
    {
        $exams = Exams::all();
        $enrollments = Student_Enrollments::with('student')->get();
        return view('marks.edit', compact('mark', 'exams', 'enrollments'));
    }

    public function update(Request $request, Marks $mark)
    {
        $isAbsent = $request->has('is_absent');

        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'student_enrollment_id' => [
                'required',
                'exists:student_enrollments,id',
                Rule::unique('marks')->where(function ($query) use ($request) {
                    return $query->where('exam_id', $request->exam_id);
                })->ignore($mark->id)
            ],
            'marks_obtained' => $isAbsent ? 'nullable|numeric|min:0|max:100' : 'required|numeric|min:0|max:100',
            'teacher_remarks' => 'nullable|string|max:500',
        ]);

        $mark->update([
            'exam_id' => $request->exam_id,
            'student_enrollment_id' => $request->student_enrollment_id,
            'marks_obtained' => $isAbsent ? 0.00 : $request->marks_obtained,
            'is_absent' => $isAbsent,
            'teacher_remarks' => $request->teacher_remarks,
        ]);

        return redirect()->route('marks.index')->with('success', 'Grade record modified successfully.');
    }

    public function destroy(Marks $mark)
    {
        $mark->delete();
        return redirect()->route('marks.index')->with('success', 'Grade ledger index node purged.');
    }
}