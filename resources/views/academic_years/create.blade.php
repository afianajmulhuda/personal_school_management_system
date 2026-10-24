@extends('layouts.master')
@section('title', 'New System Term')
@section('page-title', 'Configure Academic Calendar Sequence')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-success fw-bold"><i class="bi bi-calendar-plus me-1"></i> Register Term Metrics</h3>
            </div>
            
            <form action="{{ route('academic_years.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Academic Cycle Name Reference</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., 2026-2027 Academic" required max="20">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <div class="form-text text-muted">Provide a recognizable string format. Example: "2026-Tier1" or "Session-2026".</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label fw-bold">Term Operational Start Date</label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                            @error('start_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Term Operational End Date</label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                            @error('end_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded border">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActiveSwitch" value="1" {{ old('is_active') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="isActiveSwitch">Force Set As Live Operations Frame Context</label>
                        </div>
                        <div class="small text-muted mt-1 ms-4">Checking this automatically marks all existing academic years as inactive across the platform database layout.</div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('system.rolloverView') }}" class="btn btn-secondary me-2 px-4">Exit Matrix</a>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Commit Frame Structure</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection