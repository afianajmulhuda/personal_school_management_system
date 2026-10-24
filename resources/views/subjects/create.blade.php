@extends('layouts.master')
@section('title', 'Register Subject')
@section('page-title', 'Formulate Academic Subject')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-teal shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold" style="color: #20c997;"><i class="bi bi-journal-plus me-1"></i> Initialize Course Metrics</h3>
            </div>
            
            <form action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Subject Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="e.g., MATH101, ENG-2" required max="20">
                            @error('code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Full Subject Name Designation</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., Introduction to Calculus, Advanced Literature" required max="100">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded border mt-2">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_elective" id="isElectiveSwitch" value="1" {{ old('is_elective') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="isElectiveSwitch">Mark this Subject as an Elective course</label>
                        </div>
                        <div class="small text-muted mt-1 ms-4">When toggled off, the system forces this subject as a mandatory core requirement profile for assigned tracks.</div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn text-white px-4 fw-bold" style="background-color: #20c997;">Commit Course Node</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection