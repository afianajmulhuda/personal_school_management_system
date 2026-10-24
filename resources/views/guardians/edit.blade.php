@extends('layouts.master')
@section('title', 'Modify Guardian Record')
@section('page-title', 'Adjust Guardian Core Context Info')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Configuration for Profile Identity Matrix #{{ $guardian->id }}</h3>
            </div>
            
            <form action="{{ route('guardians.update', $guardian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    
                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom">Father Parameters</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Father Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $guardian->father_name) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Father Phone</label>
                            <input type="text" name="father_phone" class="form-control" value="{{ old('father_phone', $guardian->father_phone) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Father Profession</label>
                            <input type="text" name="father_profession" class="form-control" value="{{ old('father_profession', $guardian->father_profession) }}">
                        </div>
                    </div>

                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom">Mother Parameters</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Mother Name</label>
                            <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name', $guardian->mother_name) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mother Phone</label>
                            <input type="text" name="mother_phone" class="form-control" value="{{ old('mother_phone', $guardian->mother_phone) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mother Profession</label>
                            <input type="text" name="mother_profession" class="form-control" value="{{ old('mother_profession', $guardian->mother_profession) }}">
                        </div>
                    </div>

                    <h5 class="text-danger fw-bold mb-3 pb-1 border-bottom">Emergency Card Overrides</h5>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Emergency Contact Name *</label>
                            <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $guardian->emergency_contact_name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Emergency Contact Phone *</label>
                            <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone', $guardian->emergency_contact_phone) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Emergency Relation *</label>
                            <input type="text" name="emergency_relation" class="form-control" value="{{ old('emergency_relation', $guardian->emergency_relation) }}" required>
                        </div>
                    </div>

                    <h5 class="text-secondary fw-bold mb-3 pb-1 border-bottom">Contact & Address Trace</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Guardian Email</label>
                            <input type="email" name="guardian_email" class="form-control" value="{{ old('guardian_email', $guardian->guardian_email) }}">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Residential Address *</label>
                            <textarea name="residential_address" class="form-control" rows="2" required>{{ old('residential_address', $guardian->residential_address) }}</textarea>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('guardians.index') }}" class="btn btn-secondary me-2 px-4">Exit Fields</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Save System Corrections</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection