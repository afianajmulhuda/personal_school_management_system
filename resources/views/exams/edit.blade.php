@extends('layouts.master')
@section('title', 'Modify Assessment Metrics')
@section('page-title', 'Adjust Exam Parameters')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Exam Registry Node #{{ $exam->id }}</h3>
            </div>
            
            <form action="{{ route('exams.update', $exam->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Exam Term Block *</label>
                        <select name="exam_term_id" class="form-select" required>
                            @foreach($examTerms as $term)
                                <option value="{{ $term->id }}" {{ $exam->exam_term_id == $term->id ? 'selected' : '' }}>{{ $term->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Target Division Section *</label>
                            <select name="section_id" class="form-select" required>
                                @foreach($sections as $sec)
                                    <option value="{{ $sec->id }}" {{ $exam->section_id == $sec->id ? 'selected' : '' }}>{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Academic Subject *</label>
                            <select name="subject_id" class="form-select" required>
                                @foreach($subjects as $sub)
                                    <option value="{{ $sub->id }}" {{ $exam->subject_id == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Scheduled Execution Date *</label>
                        <input type="date" name="exam_date" class="form-control" value="{{ old('exam_date', $exam->exam_date ? $exam->exam_date->format('Y-m-d') : '') }}" required>
                    </div>

                    <div class="row bg-light p-3 rounded border">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Max Marks Obtainable *</label>
                            <input type="number" step="0.01" name="max_marks" class="form-control" value="{{ old('max_marks', $exam->max_marks) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-danger">Minimum Passing Cut-off *</label>
                            <input type="number" step="0.01" name="min_passing_marks" class="form-control" value="{{ old('min_passing_marks', $exam->min_passing_marks) }}" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('exams.index') }}" class="btn btn-secondary me-2 px-4">Discard Corrections</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Apply Schedule Adjustments</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection