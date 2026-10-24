@extends('layouts.master')
@section('title', 'Modify Calendar Grid')
@section('page-title', 'Adjust Year Metrics Framework')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Configuration Mapping</h3>
            </div>
            
            <form action="{{ route('academic_years.update', $year->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Academic Cycle Name Reference</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $year->name) }}" required max="20">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="form-label fw-bold">Term Operational Start Date</label>
                            <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $year->start_date) }}" required>
                            @error('start_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Term Operational End Date</label>
                            <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $year->end_date) }}" required>
                            @error('end_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Boolean System Operations Multi-Control Box -->
                    <div class="bg-light p-3 rounded border mb-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActiveUpdate" value="1" {{ $year->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="isActiveUpdate">Retain or Enforce Global Live Scope Status</label>
                        </div>

                        <div class="dropdown-divider border-secondary opacity-25"></div>

                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_closed" id="isClosedUpdate" value="1" {{ $year->is_closed ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-danger" for="isClosedUpdate">Seal Cycle Logs Indefinitely (Lock Ledger)</label>
                        </div>
                        <div class="small text-muted mt-1 ms-4">Warning: Marking this closed enforces read-only tracking and blocks new score input operations.</div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('system.rolloverView') }}" class="btn btn-secondary me-2 px-4">Cancel Changes</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Update Year Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection