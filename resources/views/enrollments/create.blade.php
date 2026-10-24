@extends('layouts.master')
@section('title', 'Register Enrollment')
@section('page-title', 'Map Student to Academic Term')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold text-success"><i class="bi bi-diagram-2 me-1"></i> Term Enrollment Configuration</h3>
            </div>
            
            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm pb-0 mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom">1. Target Demographics</h5>
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Select Student *</label>
                            <select name="student_id" class="form-select select2" required>
                                <option value="">Lookup Registry Profile...</option>
                                @foreach($students as $s)
                                    <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->admission_no }} - {{ $s->first_name }} {{ $s->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Target Academic Year *</label>
                            <select name="academic_year_id" class="form-select" required>
                                <option value="">Select Target Term...</option>
                                @foreach($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ old('academic_year_id') == $ay->id ? 'selected' : '' }}>{{ $ay->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom">2. Placement Matrix & Ranking</h5>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Campus Location *</label>
                            <select name="campus_id" class="form-select" required>
                                <option value="">Select Station...</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Academic Class Tier *</label>
                            <select name="class_id" class="form-select" required>
                                <option value="">Select Track Level...</option>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Section Division *</label>
                            <select name="section_id" class="form-select" required>
                                <option value="">Select Division...</option>
                                @foreach($sections as $sec)
                                    <option value="{{ $sec->id }}" {{ old('section_id') == $sec->id ? 'selected' : '' }}>{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row bg-light p-3 rounded border">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Class Roll Number *</label>
                            <input type="number" name="roll_no" class="form-control" value="{{ old('roll_no') }}" placeholder="e.g., 12" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Term Enrollment Status</label>
                            <select name="enrollment_status" class="form-select">
                                <option value="PROMOTED" {{ old('enrollment_status') == 'PROMOTED' ? 'selected' : '' }}>PROMOTED (Standard Path)</option>
                                <option value="RETAINED" {{ old('enrollment_status') == 'RETAINED' ? 'selected' : '' }}>RETAINED (Repeating Level)</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('enrollments.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Commit Placement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection