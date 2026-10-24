@extends('layouts.master')
@section('title', 'Modify Performance Metrics')
@section('page-title', 'Adjust Grade Settings Ledger')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Grade Ledger Node Context #{{ $mark->id }}</h3>
            </div>
            
            <form action="{{ route('marks.update', $mark->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Target Exam Component *</label>
                            <select name="exam_id" class="form-select" required>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ $mark->exam_id == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Student Mapping Profile *</label>
                            <select name="student_enrollment_id" class="form-select" required>
                                @foreach($enrollments as $enrollment)
                                    <option value="{{ $enrollment->id }}" {{ $mark->student_enrollment_id == $enrollment->id ? 'selected' : '' }}>
                                        {{ $enrollment->student->first_name ?? 'Admitted Student' }} {{ $enrollment->student->last_name ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded border mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_absent" id="absentSwitch" value="1" {{ $mark->is_absent ? 'checked' : '' }} onchange="toggleAbsentState(this.checked)">
                            <label class="form-check-label fw-bold text-danger" for="absentSwitch">Flag this student as ABSENT from evaluation</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Numeric Marks Obtained *</label>
                        <input type="number" step="0.01" name="marks_obtained" id="marksInput" class="form-control" value="{{ old('marks_obtained', $mark->marks_obtained) }}" {{ $mark->is_absent ? 'disabled' : 'required' }}>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Evaluator Remarks Override</label>
                        <textarea name="teacher_remarks" class="form-control" rows="3">{{ old('teacher_remarks', $mark->teacher_remarks) }}</textarea>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('marks.index') }}" class="btn btn-secondary me-2 px-4">Discard Corrections</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Save Metrics Adjustments</button>
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
            marksInput.removeAttribute('disabled');
            marksInput.setAttribute('required', 'required');
        }
    }
</script>
@endsection