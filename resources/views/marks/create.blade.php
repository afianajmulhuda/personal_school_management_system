@extends('layouts.master')
@section('title', 'Log Grade Metrics')
@section('page-title', 'Record Examination Score Metrics')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-danger shadow-sm" style="border-top: 3px solid #dc3545;">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold text-danger"><i class="bi bi-pen-fill me-1"></i> Register Student Performance Unit</h3>
            </div>
            
            <form action="{{ route('marks.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Target Exam Component *</label>
                            <select name="exam_id" class="form-select" required>
                                <option value="">Select Exam Module...</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ old('exam_id') == $exam->id ? 'selected' : '' }}>
                                        <!-- Combines Term name and Subject name for clear identification -->
                                        {{ $exam->examTerm->name ?? 'Unknown Term' }} - {{ $exam->subject->name ?? 'N/A' }} 
                                        ({{ $exam->section->name ?? 'General' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Student Identity Mapping *</label>
                            <select name="student_enrollment_id" class="form-select select2" required>
                                <option value="">Identify Active Student Roster...</option>
                                @foreach($enrollments as $enrollment)
                                    <option value="{{ $enrollment->id }}" {{ old('student_enrollment_id') == $enrollment->id ? 'selected' : '' }}>
                                        {{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }} ({{ $enrollment->class->name ?? 'N/A' }} - Roll: #{{ $enrollment->roll_no }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- ATTENDANCE OVERRIDE CAPABILITIES -->
                    <div class="p-3 bg-light rounded border mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_absent" id="absentSwitch" value="1" {{ old('is_absent') ? 'checked' : '' }} onchange="toggleAbsentState(this.checked)">
                            <label class="form-check-label fw-bold text-danger" for="absentSwitch">Flag this student as ABSENT from evaluation</label>
                        </div>
                        <div class="small text-muted mt-1 ms-4">Checking this sets points secured to 0.00 and locks text input boxes automatically.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Numeric Marks Obtained *</label>
                        <input type="number" step="0.01" name="marks_obtained" id="marksInput" class="form-control" value="{{ old('marks_obtained') }}" placeholder="e.g., 85.50" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Teacher / Evaluator Remarks</label>
                        <textarea name="teacher_remarks" class="form-control" rows="3" placeholder="Add specific execution notes or performance reviews details...">{{ old('teacher_remarks') }}</textarea>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('marks.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn btn-danger px-4 fw-bold">Record Metrics</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleAbsentState(isAbsent) {
        const marksInput = document.getElementById('marksInput');
        if (isAbsent) {
            marksInput.value = '0.00';
            marksInput.setAttribute('disabled', 'disabled');
            marksInput.removeAttribute('required');
        } else {
            marksInput.value = '';
            marksInput.removeAttribute('disabled');
            marksInput.setAttribute('required', 'required');
        }
    }
    // Initialize state on validation failures
    document.addEventListener("DOMContentLoaded", function() {
        if(document.getElementById('absentSwitch').checked) {
            toggleAbsentState(true);
        }
    });
</script>
@endsection