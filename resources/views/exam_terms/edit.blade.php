@extends('layouts.master')
@section('title', 'Modify Term Node')
@section('page-title', 'Adjust Segment Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Term Configuration Node #{{ $examTerm->id }}</h3>
            </div>
            
            <form action="{{ route('exam-terms.update', $examTerm->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Academic Session *</label>
                        <select name="academic_year_id" class="form-select" required>
                            @foreach($academicYears as $year)
                                <option value="{{ $year->id }}" {{ $examTerm->academic_year_id == $year->id ? 'selected' : '' }}>{{ $year->year_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Term Reference Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $examTerm->name) }}" maxlength="50" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cumulative Grading Weightage (%) *</label>
                        <div class="input-group">
                            <input type="number" name="weightage" min="1" max="100" class="form-control" value="{{ old('weightage', $examTerm->weightage) }}" required>
                            <span class="input-group-text bg-light text-secondary font-monospace">%</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('exam-terms.index') }}" class="btn btn-secondary me-2 px-4">Discard Changes</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Apply Modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection