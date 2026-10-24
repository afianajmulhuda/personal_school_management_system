@extends('layouts.master')
@section('title', 'Register Course Level')
@section('page-title', 'Formulate New Student Class Tier')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-indigo shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title fw-bold" style="color: #6610f2;"><i class="bi bi-folder-plus me-1"></i> Register System Class Metric</h3>
            </div>
            
            <form action="{{ route('classes.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Class Name Designation</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., Grade 10, Senior Year, Class 5" required max="50">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Numeric Level Weight Sequence</label>
                        <input type="number" name="numeric_level" class="form-control @error('numeric_level') is-invalid @enderror" value="{{ old('numeric_level') }}" placeholder="e.g., 10 (Used for index ordering structural operations)" required>
                        @error('numeric_level') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Automatic Rollover Next Target Level</label>
                        <select name="next_class_id" class="form-select @error('next_class_id') is-invalid @enderror">
                            <option value="">Leave blank (Terminal / Graduation Step)</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ old('next_class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} (Level: {{ $c->numeric_level }})</option>
                            @endforeach
                        </select>
                        @error('next_class_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <div class="form-text text-muted">Specifies where students are automatically migrated when a session transition rollover triggers.</div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn btn-indigo text-white px-4 fw-bold" style="background-color: #6610f2;">Store Level Settings</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection