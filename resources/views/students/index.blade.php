@extends('layouts.master')
@section('title', 'Student Directory')
@section('page-title', 'Student Registry Management')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-primary fw-bold mb-0">Active Admissions List</h3>
                <a href="{{ route('students.register') }}" class="btn btn-primary btn-sm ms-auto">
                    <i class="bi bi-person-plus me-1"></i> Register New Student
                </a>
            </div>
            
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 80px;">Photo</th>
                            <th>Admission No</th>
                            <th>Full Name</th>
                            <th>Campus Point</th>
                            <th>Primary Contact</th>
                            <th class="text-center">Lifecycle Status</th>
                            <th style="width: 150px;" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $student->photo_url ?? asset('dist/assets/img/avatar-placeholder.png') }}" 
                                     alt="Student Thumbnail" class="rounded-circle border shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                            </td>
                            <td><strong class="text-primary font-monospace">{{ $student->admission_no }}</strong></td>
                            <td><span class="fw-bold text-dark">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</span></td>
                            <td><span class="badge bg-secondary">{{ $student->campus->name ?? 'Unassigned Point' }}</span></td>
                            <td>
                                <div class="small"><i class="bi bi-telephone-fill text-muted me-1"></i>{{ $student->student_phone ?? 'N/A' }}</div>
                                <div class="small text-muted"><i class="bi bi-envelope-fill me-1"></i>{{ $student->student_email ?? 'N/A' }}</div>
                            </td>
                            <td class="text-center">
                                @if($student->status === 'ACTIVE')
                                    <span class="badge bg-success px-3 py-1"><i class="bi bi-check-circle me-1"></i> Active</span>
                                @elseif($student->status === 'DROPPED')
                                    <span class="badge bg-danger px-3 py-1"><i class="bi bi-x-circle me-1"></i> Dropped</span>
                                @else
                                    <span class="badge bg-info text-dark px-3 py-1"><i class="bi bi-mortarboard-fill me-1"></i> Graduated</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-outline-info me-1" title="Modify Student Info">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Warning: Purging this profile will clear historical marks/attendance linked via cascade references. Continue?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Purge Student Record">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                No student profiles currently indexed in the active database framework.
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