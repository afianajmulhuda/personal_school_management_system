<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Attendance;
use App\Models\Student_Enrollments;
use App\Models\AcademicYear;
use App\Models\AcademicYears;
use Illuminate\Http\Request;

class AttendanceProcessingEngine extends Controller
{
    public function loadAttendanceSheet(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'date' => 'required|date'
        ]);

        $activeYear = AcademicYears::where('is_active', true)->first();
        
        // Grab full operational grid roster mapped directly with historical roll parameters
        $roster = Student_Enrollments::with('student')
            ->where('section_id', $request->section_id)
            ->where('academic_year_id', $activeYear->id)
            ->orderBy('roll_no', 'asc')
            ->get();

        // Check if records are already mapped inside the attendance system for this date
        $existingRecords = Attendance::whereIn('student_enrollment_id', $roster->pluck('id'))
            ->where('attendance_date', $request->date)
            ->get()
            ->keyBy('student_enrollment_id');

        return view('attendance.sheet', [
            'roster' => $roster,
            'existingRecords' => $existingRecords,
            'date' => $request->date,
            'section_id' => $request->section_id
        ]);
    }

    public function batchStoreAttendance(Request $request)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:PRESENT,ABSENT,LATE,EXCUSED'
        ]);

        foreach ($request->attendance as $enrollmentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_enrollment_id' => $enrollmentId,
                    'attendance_date' => $request->attendance_date
                ],
                [
                    'status' => $status,
                    'marked_by_user_id' => auth()->id() ?? 1 // Fallback tracking mechanism mapping context
                ]
            );
        }

        return redirect()->back()->with('success', 'Batch daily attendance parameters updated successfully.');
    }
}