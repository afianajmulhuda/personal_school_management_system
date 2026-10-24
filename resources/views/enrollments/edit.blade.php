@extends('layouts.master')
@section('title', 'Modify Enrollment Profile')
@section('page-title', 'Adjust Term Placement')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold text-warning"><i class="bi bi-pencil-square me-1"></i> Edit Registration Node #{{ $enrollment->id }}</h3>
            </div>
            
            <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                @csrf
                @method('PUT')
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

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Select Student *</label>
                            <select name="student_id" class="form-select" required>
                                @foreach($students as $s)
                                    <option value="{{ $s->id }}" {{ $enrollment->student_id == $s->id ? 'selected' : '' }}>
                                        {{ $s->admission_no }} - {{ $s->first_name }} {{ $s->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Target Academic Year *</label>
                            <select name="academic_year_id" class="form-select" required>
                                @foreach($academicYears as $ay)
                                    <option value="{{ $ay->id }}" {{ $enrollment->academic_year_id == $ay->id ? 'selected' : '' }}>{{ $ay->year_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Campus Location *</label>
                            <select name="campus_id" class="form-select" required>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ $enrollment->campus_id == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Academic Class Tier *</label>
                            <select name="class_id" class="form-select" required>
                                @foreach($classes as $c)
                                    <option value="{{ $c->id }}" {{ $enrollment->class_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Section Division *</label>
                            <select name="section_id" class="form-select" required>
                                @foreach($sections as $sec)
                                    <option value="{{ $sec->id }}" {{ $enrollment->section_id == $sec->id ? 'selected' : '' }}>{{ $sec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row bg-light p-3 rounded border">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Class Roll Number *</label>
                            <input type="number" name="roll_no" class="form-control" value="{{ old('roll_no', $enrollment->roll_no) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Term Enrollment Status</label>
                            <select name="enrollment_status" class="form-select">
                                <option value="PROMOTED" {{ $enrollment->enrollment_status == 'PROMOTED' ? 'selected' : '' }}>PROMOTED</option>
                                <option value="RETAINED" {{ $enrollment->enrollment_status == 'RETAINED' ? 'selected' : '' }}>RETAINED</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('enrollments.index') }}" class="btn btn-secondary me-2 px-4">Cancel Modifications</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Apply Placement Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection