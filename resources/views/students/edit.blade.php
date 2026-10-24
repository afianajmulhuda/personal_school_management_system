@extends('layouts.master')
@section('title', 'Modify Student Profile')
@section('page-title', 'Adjust Registry Profile Mapping')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Core Demographics Frame</h3>
            </div>
            
            <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!-- REUSED FORMS METRICS PREPOPULATED -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Admission Number *</label>
                            <input type="text" name="admission_no" class="form-control @error('admission_no') is-invalid @enderror" value="{{ old('admission_no', $student->admission_no) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Target Operational Campus</label>
                            <select name="campus_id" class="form-select">
                                <option value="">Select Location...</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ $student->campus_id == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Assigned Guardian *</label>
                            <select name="guardian_id" class="form-select" required>
                                @foreach($guardians as $g)
                                    <option value="{{ $g->id }}" {{ $student->guardian_id == $g->id ? 'selected' : '' }}>{{ $g->guardian_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">First Name *</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $student->middle_name) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Last Name *</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Student Phone</label>
                            <input type="text" name="student_phone" class="form-control" value="{{ old('student_phone', $student->student_phone) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Student Email</label>
                            <input type="email" name="student_email" class="form-control" value="{{ old('student_email', $student->student_email) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Current System Status Framework Context</label>
                            <select name="status" class="form-select">
                                <option value="ACTIVE" {{ $student->status === 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                                <option value="DROPPED" {{ $student->status === 'DROPPED' ? 'selected' : '' }}>DROPPED</option>
                                <option value="GRADUATED" {{ $student->status === 'GRADUATED' ? 'selected' : '' }}>GRADUATED</option>
                            </select>
                        </div>
                    </div>

                    <!-- FIXED ROW FOR DATA INTEGRITY BOUNDARIES -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Date of Birth *</label>
                            <input type="date" name="date_of_birth" class="form-control" value="{{ $student->date_of_birth }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Gender Specification *</label>
                            <input type="text" name="gender" class="form-control" value="{{ $student->gender }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Blood Group</label>
                            <input type="text" name="blood_group" class="form-control" value="{{ $student->blood_group }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Nationality</label>
                            <input type="text" name="nationality" class="form-control" value="{{ $student->nationality }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Current Mailing Address</label>
                            <textarea name="current_address" class="form-control" rows="2">{{ old('current_address', $student->current_address) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Permanent Address Base</label>
                            <textarea name="permanent_address" class="form-control" rows="2">{{ old('permanent_address', $student->permanent_address) }}</textarea>
                        </div>
                    </div>

                    <div class="row bg-light p-3 rounded border align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ $student->photo_url ?? asset('dist/assets/img/avatar-placeholder.png') }}" alt="Current Photo Profile" class="img-thumbnail rounded" style="max-height: 100px;">
                        </div>
                        <div class="col-md-10">
                            <label class="form-label fw-bold">Replace Current Profile Portrait Graphic</label>
                            <input type="file" name="photo" class="form-control">
                            <span class="form-text text-muted">Leave unselected to keep current verification thumbnail files.</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary me-2 px-4">Cancel Changes</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Commit Updated Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection