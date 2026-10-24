@extends('layouts.master')
@section('title', 'New Section Setup')
@section('page-title', 'Create Infrastructure Class Section')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-outline card-info shadow-sm">
            <div class="card-header bg-white">
                <h3 class="card-title text-info fw-bold"><i class="bi bi-plus-circle me-1"></i> Allocate Section Infrastructure</h3>
            </div>
            
            <form action="{{ route('sections.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Target Operational Campus</label>
                        <select name="campus_id" class="form-select @error('campus_id') is-invalid @enderror" required>
                            <option value="">Select Campus Location Target...</option>
                            @foreach($campuses as $campus)
                                <option value="{{ $campus->id }}" {{ old('campus_id') == $campus->id ? 'selected' : '' }}>{{ $campus->name }}</option>
                            @endforeach
                        </select>
                        @error('campus_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Parent Course / Class Tier</label>
                        <select name="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                            <option value="">Select Class Assignment Core...</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Section Identification String Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., Section A, Gold Track, Premium" required max="50">
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Max Roster Capacity Ceiling</label>
                            <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', 40) }}" min="1" required>
                            @error('capacity') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-bold">Physical Room Identifier Key</label>
                            <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number') }}" placeholder="e.g., Room-402, Block-B" max="20">
                            @error('room_number') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top text-end py-3">
                    <a href="{{ route('sections.index') }}" class="btn btn-secondary me-2 px-4">Cancel</a>
                    <button type="submit" class="btn btn-info text-white px-4 fw-bold">Compile and Launch Section</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection