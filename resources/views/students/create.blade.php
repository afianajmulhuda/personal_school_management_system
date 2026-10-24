@extends('layouts.master')
@section('title', 'Student Admission')
@section('page-title', 'Admit Student Entry')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-primary fw-bold"><i class="bi bi-person-badge-fill me-1"></i> Core Demographic Profile Setup</h3>
            </div>
            
            <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- BLOCK 1: ADMISSION METRICS -->
                    <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">1. Institutional Admission Metrics</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Admission Number *</label>
                            <input type="text" name="admission_no" class="form-control @error('admission_no') is-invalid @enderror" value="{{ old('admission_no') }}" required>
                            @error('admission_no') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Target Operational Campus</label>
                            <select name="campus_id" class="form-select @error('campus_id') is-invalid @enderror">
                                <option value="">Select Station Location...</option>
                                @foreach($campuses as $campus)
                                    <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                                @endforeach
                            </select>
                            @error('campus_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Assigned Guardian *</label>
                            <select name="guardian_id" class="form-select @error('guardian_id') is-invalid @enderror" required>
                                <option value="">Map Primary Contact Guardian...</option>
                                @foreach($guardians as $g)
                                    <option value="{{ $g->id }}" {{ old('guardian_id') == $g->id ? 'selected' : '' }}>{{ $g->father_name }}</option>
                                @endforeach
                            </select>
                            @error('guardian_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- BLOCK 2: STUDENT DETAILS -->
                    <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">2. Personal Demographics</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">First Name *</label>
                            <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Last Name *</label>
                            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Date of Birth *</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Gender Specification *</label>
                            <select name="gender" class="form-select" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Blood Group</label>
                            <input type="text" name="blood_group" class="form-control" placeholder="e.g., O+, A-" value="{{ old('blood_group') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Nationality</label>
                            <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'Citizen') }}">
                        </div>
                    </div>

                    <!-- BLOCK 3: IDENTITY & CONTACT -->
                    <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">3. Communications Network & Identity Info</h5>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Religion Structure</label>
                            <input type="text" name="religion" class="form-control" value="{{ old('religion') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Student Phone</label>
                            <input type="text" name="student_phone" class="form-control" value="{{ old('student_phone') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Student Email</label>
                            <input type="email" name="student_email" class="form-control @error('student_email') is-invalid @enderror" value="{{ old('student_email') }}">
                            @error('student_email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Registration Action Date *</label>
                            <input type="date" name="registration_date" class="form-control" value="{{ old('registration_date', date('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Current Mailing Address</label>
                            <textarea name="current_address" class="form-control" rows="2">{{ old('current_address') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Permanent Address Base</label>
                            <textarea name="permanent_address" class="form-control" rows="2">{{ old('permanent_address') }}</textarea>
                        </div>
                    </div>

                    <!-- BLOCK 4: ATTRIBUTES & ASSETS -->
                    <h5 class="text-secondary fw-bold mb-3 border-bottom pb-2">4. Status & Photographic Identity Verification</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Initial System Status Flag</label>
                            <select name="status" class="form-select">
                                <option value="ACTIVE" selected>ACTIVE</option>
                                <option value="DROPPED">DROPPED</option>
                                <option value="GRADUATED">GRADUATED</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Upload Student Portrait Photo (Max 2MB)</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('students.index') }}" class="btn btn-secondary me-2 px-4">Exit Entry Matrix</a>
                    <button type="submit" class="btn btn-primary px-4 fw-bold">Store and Verify Student Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection