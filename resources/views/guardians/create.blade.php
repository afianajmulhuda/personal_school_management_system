@extends('layouts.master')
@section('title', 'Register Guardian')
@section('page-title', 'Establish Family Node Configuration')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-outline card-indigo shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold text-indigo"><i class="bi bi-person-vcard me-1"></i> File New Family Household Record</h3>
            </div>
            
            <form action="{{ route('guardians.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    <!-- COLUMN 1: FATHER PARAMETERS -->
                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom"><i class="bi bi-gender-male me-1"></i> Father Profile Meta</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Father's Full Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ old('father_name') }}" placeholder="John Doe Senior">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Father's Phone Number</label>
                            <input type="text" name="father_phone" class="form-control" value="{{ old('father_phone') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Father's Profession</label>
                            <input type="text" name="father_profession" class="form-control" value="{{ old('father_profession') }}">
                        </div>
                    </div>

                    <!-- COLUMN 2: MOTHER PARAMETERS -->
                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom"><i class="bi bi-gender-female me-1"></i> Mother Profile Meta</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Mother's Full Name</label>
                            <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mother's Phone Number</label>
                            <input type="text" name="mother_phone" class="form-control" value="{{ old('mother_phone') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mother's Profession</label>
                            <input type="text" name="mother_profession" class="form-control" value="{{ old('mother_profession') }}">
                        </div>
                    </div>

                    <!-- COLUMN 3: EMERGENCY MANDATORY PARAMETERS -->
                    <h5 class="text-danger fw-bold mb-3 pb-1 border-bottom"><i class="bi bi-exclamation-octagon-fill me-1"></i> Mandatory Emergency Point of Contact Matrix</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Emergency Contact Name *</label>
                            <input type="text" name="emergency_contact_name" class="form-control @error('emergency_contact_name') is-invalid @enderror" value="{{ old('emergency_contact_name') }}" required>
                            @error('emergency_contact_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Emergency Phone *</label>
                            <input type="text" name="emergency_contact_phone" class="form-control @error('emergency_contact_phone') is-invalid @enderror" value="{{ old('emergency_contact_phone') }}" required>
                            @error('emergency_contact_phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Relationship to Student *</label>
                            <input type="text" name="emergency_relation" class="form-control @error('emergency_relation') is-invalid @enderror" value="{{ old('emergency_relation') }}" placeholder="e.g., Uncle, Stepfather, Grandmother" required>
                            @error('emergency_relation') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- COLUMN 4: SHARED SYSTEM ADDRESS META -->
                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom"><i class="bi bi-geo-alt me-1"></i> Core Comms & Geographic Address</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Guardian Primary Email Account</label>
                            <input type="email" name="guardian_email" class="form-control @error('guardian_email') is-invalid @enderror" value="{{ old('guardian_email') }}" placeholder="family@example.com">
                            @error('guardian_email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Residential Household Address *</label>
                            <textarea name="residential_address" class="form-control @error('residential_address') is-invalid @enderror" rows="2" placeholder="Full street layout geolocation parameters..." required>{{ old('residential_address') }}</textarea>
                            @error('residential_address') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('guardians.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn btn-indigo text-white px-4 fw-bold" style="background-color: #4e73df;">Commit Family Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection