<?php
namespace App\Http\Controllers;

use App\Models\Student_Enrollments;
use App\Models\Students;
use App\Models\AcademicYears;
use App\Models\Campus;
use App\Models\classes;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentEnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Student_Enrollments::with(['student', 'academicYear', 'campus', 'class', 'section'])
            ->orderBy('academic_year_id', 'desc')
            ->orderBy('class_id', 'asc')
            ->orderBy('roll_no', 'asc')
            ->get();
        // dd($enrollments);
            
        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Students::orderBy('first_name')->get();
        $academicYears = AcademicYears::orderBy('name', 'desc')->get();
        $campuses = Campus::all();
        $classes = classes::orderBy('numeric_level', 'asc')->get();
        $sections = Sections::orderBy('name', 'asc')->get();
        
        return view('enrollments.create', compact('students', 'academicYears', 'campuses', 'classes', 'sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'campus_id' => 'required|exists:campuses,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'enrollment_status' => 'required|in:PROMOTED,RETAINED',
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('student_enrollments')->where(function ($query) use ($request) {
                    return $query->where('academic_year_id', $request->academic_year_id);
                })
            ],
            'roll_no' => [
                'required',
                'integer',
                Rule::unique('student_enrollments')->where(function ($query) use ($request) {
                    return $query->where('academic_year_id', $request->academic_year_id)
                                 ->where('campus_id', $request->campus_id)
                                 ->where('class_id', $request->class_id)
                                 ->where('section_id', $request->section_id);
                })
            ],
        ], [
            'student_id.unique' => 'This student is already enrolled in the selected academic year.',
            'roll_no.unique' => 'This roll number is already assigned within this specific year, campus, class, and section.'
        ]);

        Student_Enrollments::create($request->all());

        return redirect()->route('enrollments.index')->with('success', 'Student successfully enrolled for the academic term.');
    }

    public function edit(Student_Enrollments $enrollment)
    {
        $students = Students::orderBy('first_name')->get();
        $academicYears = AcademicYears::orderBy('name', 'desc')->get();
        $campuses = Campus::all();
        $classes = classes::orderBy('numeric_level', 'asc')->get();
        $sections = Sections::orderBy('name', 'asc')->get();
        
        return view('enrollments.edit', compact('enrollment', 'students', 'academicYears', 'campuses', 'classes', 'sections'));
    }

    public function update(Request $request, Student_Enrollments $enrollment)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'campus_id' => 'required|exists:campuses,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'enrollment_status' => 'required|in:PROMOTED,RETAINED',
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('student_enrollments')->where(function ($query) use ($request) {
                    return $query->where('academic_year_id', $request->academic_year_id);
                })->ignore($enrollment->id)
            ],
            'roll_no' => [
                'required',
                'integer',
                Rule::unique('student_enrollments')->where(function ($query) use ($request) {
                    return $query->where('academic_year_id', $request->academic_year_id)
                                 ->where('campus_id', $request->campus_id)
                                 ->where('class_id', $request->class_id)
                                 ->where('section_id', $request->section_id);
                })->ignore($enrollment->id)
            ],
        ]);

        $enrollment->update($request->all());

        return redirect()->route('enrollments.index')->with('success', 'Enrollment parameters modified successfully.');
    }

    public function destroy(Student_Enrollments $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Enrollment matrix configuration purged.');
    }
}