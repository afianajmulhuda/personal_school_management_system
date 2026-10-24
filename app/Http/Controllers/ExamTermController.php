<?php

namespace App\Http\Controllers;

use App\Models\AcademicYears;
use App\Models\Exam_Terms;
use Illuminate\Http\Request;

class ExamTermController extends Controller
{
    public function index()
    {
        $examTerms = Exam_Terms::with('academicYear')
            ->orderBy('academic_year_id', 'desc')
            ->orderBy('id', 'asc')
            ->get();
            
        return view('exam_terms.index', compact('examTerms'));
    }

    public function create()
    {
        $academicYears = AcademicYears::orderBy('name', 'desc')->get();
        return view('exam_terms.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:50',
            'weightage' => 'required|integer|min:1|max:100',
        ]);

        Exam_Terms::create($request->all());

        return redirect()->route('exam-terms.index')->with('success', 'Exam term structure created successfully.');
    }

    public function edit(Exam_Terms $examTerm)
    {
        $academicYears = AcademicYears::orderBy('name', 'desc')->get();
        return view('exam_terms.edit', compact('examTerm', 'academicYears'));
    }

    public function update(Request $request, Exam_Terms $examTerm)
    {
        $request->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'name' => 'required|string|max:50',
            'weightage' => 'required|integer|min:1|max:100',
        ]);

        $examTerm->update($request->all());

        return redirect()->route('exam-terms.index')->with('success', 'Exam term configuration adjusted successfully.');
    }

    public function destroy(Exam_Terms $examTerm)
    {
        // cascade deletion handles removing down-stream child records cleanly
        $examTerm->delete();
        return redirect()->route('exam-terms.index')->with('success', 'Exam term node dropped from structural records.');
    }
}