@extends('layouts.master')
@section('title', isset($campus) ? 'Modify Campus' : 'New Campus')
@section('page-title', isset($campus) ? 'Edit Campus Details' : 'Register New Campus')

@section('content')
<div class="card card-primary max-width-600">
    <form action="{{ isset($campus) ? route('campuses.update', $campus->id) : route('campuses.store') }}" method="POST">
        @csrf
        @if(isset($campus)) @method('PUT') @endif
        
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Campus Structural Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $campus->name ?? '') }}" required placeholder="e.g., North Regional Campus">
                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Campus Unique Code Identifier</label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $campus->code ?? '') }}" required placeholder="e.g., CAMP-NORTH">
                @error('code') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Physical Address Blueprint</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $campus->address ?? '') }}</textarea>
            </div>
        </div>
        <div class="card-footer bg-light text-end">
            <a href="{{ route('campuses.index') }}" class="btn btn-secondary me-2">Cancel</a>
            <button type="submit" class="btn btn-success">{{ isset($campus) ? 'Update Campus' : 'Save Record' }}</button>
        </div>
    </form>
</div>
@endsection