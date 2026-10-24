<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use App\Models\Marks;
use App\Models\Student_Enrollments;
use Illuminate\Http\Request;

class ExamMarksController extends Controller
{
    public function captureMarksGrid(Exams $exam)
    {
        // Fetch student list linked to this exam's scope configuration track
        $classRoster = Student_Enrollments::with('student')
            ->where('section_id', $exam->section_id)
            ->where('academic_year_id', $exam->examTerm->academic_year_id)
            ->orderBy('roll_no', 'asc')
            ->get();

        $savedMarksLedger = Marks::where('exam_id', $exam->id)
            ->get()
            ->keyBy('student_enrollment_id');

        return view('exams.capture-marks', compact('exam', 'classRoster', 'savedMarksLedger'));
    }

    public function pushMarksRegistry(Request $request, Exams $exam)
    {
        $request->validate([
            'marks' => 'required|array',
            'marks.*.obtained' => 'nullable|numeric|min:0',
            'marks.*.absent' => 'nullable|boolean'
        ]);

        foreach ($request->marks as $enrollmentId => $dataset) {
            $obtainedMark = $dataset['obtained'] ?? 0;
            $isAbsent = isset($dataset['absent']) && $dataset['absent'] == '1';

            // Boundary Condition Guard Rail: Reject if input exceeds maximum allowed score
            if ($obtainedMark > $exam->max_marks) {
                return back()->withErrors("Input score overflow occurred. Value exceeds limit ceiling of {$exam->max_marks}.");
            }

            Marks::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'student_enrollment_id' => $enrollmentId
                ],
                [
                    'marks_obtained' => $isAbsent ? 0.00 : $obtainedMark,
                    'is_absent' => $isAbsent,
                ]
            );
        }

        return redirect()->back()->with('success', 'Academic performance score configuration array stored safely.');
    }
}