@extends('layouts.master')
@section('title', 'Schedule Exam')
@section('page-title', 'Create Assessment Framework')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline shadow-sm" style="border-top: 3px solid #6f42c1;">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold" style="color: #6f42c1;"><i class="bi bi-calendar-range-fill me-1"></i> Register New Evaluation Node</h3>
            </div>
            
            <form action="{{ route('exams.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Active Exam Term *</label>
                        <select name="exam_term_id" class="form-select" required>
                            <option value="">Select Term Structure...</option>
                            @foreach($examTerms as $term)
                                <option value="{{ $term->id }}" {{ old('exam_term_id') == $term->id ? 'selected' : '' }}>{{ $term->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Target Division Section *</label>
                            <select name="section_id" class="form-select" required>
                                <option value="">Select Target Class Track...</option>
                                @foreach($sections as $sec)
                                    <option value="{{ $sec->id }}" {{ old('section_id') == $sec->id ? 'selected' : '' }}>{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Academic Subject *</label>
                            <select name="subject_id" class="form-select" required>
                                <option value="">Identify Core Discipline...</option>
                                @foreach($subjects as $sub)
                                    <option value="{{ $sub->id }}" {{ old('subject_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Scheduled Execution Date *</label>
                        <input type="date" name="exam_date" class="form-control" value="{{ old('exam_date') }}" required>
                    </div>

                    <div class="row bg-light p-3 rounded border">
                        <div class="col-md-6 mb-2">
                            <label class="form-label fw-bold text-dark">Max Marks Obtainable *</label>
                            <input type="number" step="0.01" min="1" name="max_marks" id="maxMarks" class="form-control" placeholder="e.g., 100.00" value="{{ old('max_marks') }}" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label fw-bold text-danger">Minimum Passing Cut-off *</label>
                            <input type="number" step="0.01" min="0" name="min_passing_marks" id="minMarks" class="form-control" placeholder="e.g., 33.00" value="{{ old('min_passing_marks') }}" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('exams.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn text-white px-4 fw-bold" style="background-color: #6f42c1;">Commit Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection