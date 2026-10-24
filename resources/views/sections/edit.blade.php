@extends('layouts.master')
@section('title', 'Modify Section Structure')
@section('page-title', 'Adjust Infrastructure Parameters')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-warning shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-warning fw-bold"><i class="bi bi-pencil-square me-1"></i> Edit Section Profile Configuration</h3>
            </div>
            
            <form action="{{ route('sections.update', $section->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Operational Campus</label>
                        <select name="campus_id" class="form-select" required>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}" {{ $section->campus_id == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Course / Class Tier</label>
                        <select name="class_id" class="form-select" required>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ $section->class_id == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Section Identification String Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $section->name) }}" required max="50">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Max Roster Capacity Ceiling</label>
                            <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', $section->capacity) }}" min="1" required>
                            @error('capacity') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Physical Room Identifier Key</label>
                            <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number', $section->room_number) }}" max="20">
                            @error('room_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('sections.index') }}" class="btn btn-secondary me-2 px-4">Exit Fields</a>
                    <button type="submit" class="btn btn-warning text-dark px-4 fw-bold">Commit Pipeline Fixes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection