@extends('layouts.master')
@section('title', 'Student Enrollments')
@section('page-title', 'Academic Term Enrollments')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-outline card-success shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-success fw-bold mb-0">Active Enrollment Matrix</h3>
                <a href="{{ route('enrollments.create') }}" class="btn btn-success btn-sm ms-auto">
                    <i class="bi bi-node-plus-fill me-1"></i> Register Term Enrollment
                </a>
            </div>
            
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Academic Year</th>
                            <th>Student Demographics</th>
                            <th>Placement Track (Campus > Class > Sec)</th>
                            <th class="text-center">Roll No</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $enrollment)
                        <tr>
                            <td><span class="badge bg-secondary">{{ $enrollment->academicYear->name ?? 'N/A' }}</span></td>
                            <td>
                                <strong>{{ $enrollment->student->first_name }} {{ $enrollment->student->last_name }}</strong>
                                <div class="small text-muted">{{ $enrollment->student->admission_no }}</div>
                            </td>
                            <td>
                                <div class="small fw-bold">{{ $enrollment->campus->name ?? 'N/A' }}</div>
                                <span class="text-muted">{{ $enrollment->class->name ?? 'N/A' }} - Sec: {{ $enrollment->section->name ?? 'N/A' }}</span>
                            </td>
                            <td class="text-center"><span class="badge bg-light border text-dark fs-6">{{ $enrollment->roll_no }}</span></td>
                            <td class="text-center">
                                @if($enrollment->enrollment_status === 'PROMOTED')
                                    <span class="badge bg-success px-2 py-1">PROMOTED</span>
                                @else
                                    <span class="badge bg-warning text-dark px-2 py-1">RETAINED</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('enrollments.edit', $enrollment->id) }}" class="btn btn-sm btn-outline-info me-1" title="Modify Placement">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('enrollments.destroy', $enrollment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purging this enrollment drops the student from the active register for this term. Proceed?');">
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
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-journal-album fs-1 d-block mb-2"></i>
                                No active enrollments mapped in the system infrastructure.
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