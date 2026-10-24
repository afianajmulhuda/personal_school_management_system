@extends('layouts.master')
@section('title', 'Define Exam Term')
@section('page-title', 'Establish Evaluation Sequence')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline shadow-sm" style="border-top: 3px solid #fd7e14;">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold" style="color: #fd7e14;"><i class="bi bi-collection-fill me-1"></i> New Exam Term Component</h3>
            </div>
            
            <form action="{{ route('exam-terms.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Parent Academic Session *</label>
                        <select name="academic_year_id" class="form-select" required>
                            <option value="">Choose Targeted Year...</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Term Reference Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., First Terminal Examination, Mid-Term" value="{{ old('name') }}" maxlength="50" required>
                        <div class="form-text">Limit designation string elements to under 50 characters.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cumulative Grading Weightage (%) *</label>
                        <div class="input-group">
                            <input type="number" name="weightage" min="1" max="100" class="form-control" placeholder="e.g., 25" value="{{ old('weightage', 100) }}" required>
                            <span class="input-group-text bg-light text-secondary font-monospace">%</span>
                        </div>
                        <div class="form-text text-muted">Defines execution share ratio used inside overall report calculations (1 - 100).</div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('exam-terms.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn text-white px-4 fw-bold" style="background-color: #fd7e14;">Build Term Structure</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection