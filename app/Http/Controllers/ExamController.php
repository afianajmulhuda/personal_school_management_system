<?php

namespace App\Http\Controllers;

use App\Models\Exams;
use App\Models\Exam_Terms;
use App\Models\Sections;
use App\Models\Subjects;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exams::with(['examTerm', 'section', 'subject'])
            ->orderBy('exam_date', 'desc')
            ->get();
            
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        $examTerms = Exam_Terms::orderBy('id', 'desc')->get();
        $sections = Sections::orderBy('name', 'asc')->get();
        $subjects = Subjects::orderBy('name', 'asc')->get();
        
        return view('exams.create', compact('examTerms', 'sections', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_term_id' => 'required|exists:exam_terms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'max_marks' => 'required|numeric|min:1|max:999.99',
            'min_passing_marks' => 'required|numeric|min:0|lte:max_marks',
        ], [
            'min_passing_marks.lte' => 'The passing thresholds cannot exceed maximum configuration ceilings.'
        ]);

        Exams::create($request->all());

        return redirect()->route('exams.index')->with('success', 'Exam element scheduled successfully.');
    }

    public function edit(Exams $exam)
    {
        $examTerms = Exam_Terms::all();
        $sections = Sections::all();
        $subjects = Subjects::all();
        
        return view('exams.edit', compact('exam', 'examTerms', 'sections', 'subjects'));
    }

    public function update(Request $request, Exams $exam)
    {
        $request->validate([
            'exam_term_id' => 'required|exists:exam_terms,id',
            'section_id' => 'required|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_date' => 'required|date',
            'max_marks' => 'required|numeric|min:1|max:999.99',
            'min_passing_marks' => 'required|numeric|min:0|lte:max_marks',
        ], [
            'min_passing_marks.lte' => 'The passing thresholds cannot exceed maximum configuration ceilings.'
        ]);

        $exam->update($request->all());

        return redirect()->route('exams.index')->with('success', 'Exam parameters updated successfully.');
    }

    public function destroy(Exams $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam node purged from system context.');
    }
}