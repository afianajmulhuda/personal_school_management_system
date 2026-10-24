@extends('layouts.master')
@section('title', 'Sections Matrix')
@section('page-title', 'Manage Sections & Room Tracks')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-outline card-info shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-info fw-bold mb-0">Active Campus Section Deployments</h3>
                <a href="{{ route('sections.create') }}" class="btn btn-info text-white btn-sm ms-auto">
                    <i class="bi bi-plus-square me-1"></i> Add New Section
                </a>
            </div>
            
            <div class="card-body p-0">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 70px;" class="text-center">ID</th>
                            <th>Campus Point</th>
                            <th>Class Level</th>
                            <th>Section Tag</th>
                            <th class="text-center">Room Allocation</th>
                            <th class="text-center">Seat Capacity Ceiling</th>
                            <th style="width: 150px;" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $sect)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $sect->id }}</td>
                            <td><span class="badge bg-secondary">{{ $sect->campus->name ?? 'N/A' }}</span></td>
                            <td><strong class="text-dark">{{ $sect->schoolClass->name ?? 'N/A' }}</strong></td>
                            <td><span class="fw-bold text-primary fs-6">{{ $sect->name }}</span></td>
                            <td class="text-center text-monospace text-navy fw-bold">{{ $sect->room_number ?? 'Unassigned' }}</td>
                            <td class="text-center">
                                <span class="badge bg-dark px-3">{{ $sect->capacity }} Desk Slots</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('sections.edit', $sect->id) }}" class="btn btn-sm btn-outline-info me-1" title="Modify Layout">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('sections.destroy', $sect->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Warning: Dropping this section will purge all student enrollments mapped under this structural tag via cascading delete logic. Proceed?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Purge Section">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-building fs-1 d-block mb-2"></i>
                                No room track or class sections registered inside the system core.
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