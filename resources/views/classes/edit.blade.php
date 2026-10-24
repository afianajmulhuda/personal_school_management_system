@extends('layouts.master')
@section('title', 'Modify Class Configuration')
@section('page-title', 'Adjust Structural Tier Mapping')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Class Hierarchy Parameters</h3>
            </div>
            
            <form action="{{ route('classes.update', $schoolClass->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Class Name Designation</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $schoolClass->name) }}" required max="50">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Numeric Level Weight Sequence</label>
                        <input type="number" name="numeric_level" class="form-control @error('numeric_level') is-invalid @enderror" value="{{ old('numeric_level', $schoolClass->numeric_level) }}" required>
                        @error('numeric_level') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Automatic Rollover Next Target Level</label>
                        <select name="next_class_id" class="form-select @error('next_class_id') is-invalid @enderror">
                            <option value="">Leave blank (Terminal / Graduation Step)</option>
                            @foreach($availableClasses as $avail)
                                <option value="{{ $avail->id }}" {{ $schoolClass->next_class_id == $avail->id ? 'selected' : '' }}>{{ $avail->name }}</option>
                            @endforeach
                        </select>
                        @error('next_class_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Save System Corrections</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection