@extends('layouts.master')
@section('title', 'Academic Tiers')
@section('page-title', 'Class Levels & Streams Setup')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $errors->first() }}
            </div>
        @endif

        <div class="card card-outline card-indigo shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-indigo fw-bold mb-0">System Academic Classes Hierarchy</h3>
                <a href="{{ route('classes.create') }}" class="btn btn-indigo btn-sm ms-auto text-white" style="background-color: #6610f2;">
                    <i class="bi bi-plus-circle me-1"></i> Add New Tier
                </a>
            </div>
            
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 100px;" class="text-center">Hierarchy Rank</th>
                            <th>Class Identification Label</th>
                            <th class="text-center">Numeric Level Code</th>
                            <th>Next Advancement Promotion Route Target</th>
                            <th style="width: 150px;" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $class)
                        <tr>
                            <td class="text-center fw-bold text-indigo">#{{ $loop->iteration }}</td>
                            <td><strong class="text-dark fs-6">{{ $class->name }}</strong></td>
                            <td class="text-center"><span class="badge bg-secondary px-3 py-1">{{ $class->numeric_level }}</span></td>
                            <td>
                                @if($class->nextClass)
                                    <span class="text-successfw-bold"><i class="bi bi-arrow-right-short"></i> {{ $class->nextClass->name }}</span>
                                @else
                                    <span class="text-muted italic"><i class="bi bi-dash-circle"></i> Graduation Terminus (Terminal Level)</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-outline-info me-1" title="Adjust Parameters">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this level tier layout context point?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Purge Record">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-diagram-3 fs-1 d-block mb-2"></i>
                                No academic level layers registered.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection