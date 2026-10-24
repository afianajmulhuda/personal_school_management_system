<?php

namespace App\Http\Controllers;

use App\Models\Exam_Terms;
use App\Models\Marks;
use App\Models\Exams;
use App\Models\Student_Enrollments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // 1. Dashboard entry portal
    public function index()
    {
        // Get unique classes directly from your existing student enrollment structures
        // (Uses relationship to 'class' to get names if class is a separate model)
        $enrollments = Student_Enrollments::with('class')->get();
        
        // Dynamic collection of unique class models
        $classes = $enrollments->pluck('class')->unique('id')->filter();
        $examTerms = Exam_Terms::orderBy('id', 'desc')->get();

        return view('reports.index', compact('classes', 'examTerms'));
    }

    // 2. Automated Roll Number Generator using existing enrollment table
    public function regenerateRoll(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id' // Adjust to your classes table name if different
        ]);

        $classId = $request->class_id;

        DB::transaction(function () use ($classId) {
            // Fetch all students in this class, sorted alphabetically by student name
            $enrollments = Student_Enrollments::where('class_id', $classId)
                ->join('students', 'student_enrollments.student_id', '=', 'students.id')
                ->orderBy('students.last_name', 'asc')
                ->orderBy('students.first_name', 'asc')
                ->select('student_enrollments.*')
                ->get();

            $roll = 1;
            foreach ($enrollments as $enrollment) {
                // Safely updates the 'roll_number' column on your existing student_enrollments table
                $enrollment->roll_number = $roll;
                $enrollment->save();
                $roll++;
            }
        });

        return redirect()->route('reports.index')->with('success', 'Roll numbers generated successfully based on alphabetical order.');
    }

    // 3. Class-wide Consolidated Marks Sheet compiler
    public function classMarksheet(Request $request)
    {
        $request->validate([
            'class_id'     => 'required|exists:classes,id',
            'exam_term_id' => 'required|exists:exam_terms,id'
        ]);

        $examTerm = Exam_Terms::findOrFail($request->exam_term_id);

        // Fetch students in this class with their marks relative to exams belonging to the selected Exam Term
        $students = Student_Enrollments::where('class_id', $request->class_id)
            ->with(['student', 'class', 'section'])
            ->orderBy('roll_no', 'asc')
            ->get();

        // Get all configured exams for this specific exam term and class/sections to build dynamic subject columns
        $exams = Exams::where('exam_term_id', $request->exam_term_id)
            ->with('subject')
            ->get()
            ->unique('subject_id');

        // Map marks to students
        foreach ($students as $student) {
            $studentMarks = [];
            $totalObtained = 0;
            $totalMax = 0;

            foreach ($exams as $exam) {
                // Find mark matching the student's enrollment and this exam config
                $markRecord = Marks::where('student_enrollment_id', $student->id)
                    ->where('exam_id', $exam->id)
                    ->first();

                if ($markRecord) {
                    $studentMarks[$exam->subject_id] = $markRecord->is_absent ? 'Absent' : $markRecord->marks_obtained;
                    if (!$markRecord->is_absent) {
                        $totalObtained += $markRecord->marks_obtained;
                    }
                } else {
                    $studentMarks[$exam->subject_id] = '-'; // Not entered yet
                }
                $totalMax += $exam->max_marks;
            }

            $student->subject_marks = $studentMarks;
            $student->total_obtained = $totalObtained;
            $student->total_max = $totalMax;
            $student->percentage = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
        }

        return view('reports.marksheet_class', compact('students', 'exams', 'examTerm'));
    }
}