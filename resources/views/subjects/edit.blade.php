@extends('layouts.master')
@section('title', 'Modify Subject Parameters')
@section('page-title', 'Adjust Curriculum Framework')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Subject Profile Details</h3>
            </div>
            
            <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Subject Code</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $subject->code) }}" required max="20">
                            @error('code') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Full Subject Name Designation</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $subject->name) }}" required max="100">
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded border mt-2">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_elective" id="isElectiveUpdate" value="1" {{ $subject->is_elective ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="isElectiveUpdate">Mark this Subject as an Elective course</label>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('subjects.index') }}" class="btn btn-secondary me-2 px-4">Exit Fields</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Update System Records</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection