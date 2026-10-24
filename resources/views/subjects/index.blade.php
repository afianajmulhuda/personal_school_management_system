@extends('layouts.master')
@section('title', 'Subject Matrix')
@section('page-title', 'Course Curriculum Registry')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-outline card-teal shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-teal fw-bold mb-0">Registered Course Subjects</h3>
                <a href="{{ route('subjects.create') }}" class="btn btn-teal btn-sm ms-auto text-white" style="background-color: #20c997;">
                    <i class="bi bi-book-half me-1"></i> Register New Subject
                </a>
            </div>
            
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;" class="text-center">ID</th>
                            <th style="width: 150px;">Subject Code</th>
                            <th>Subject Title Name</th>
                            <th class="text-center">Classification Category</th>
                            <th style="width: 150px;" class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                        <tr>
                            <td class="text-center text-muted fw-bold">{{ $subject->id }}</td>
                            <td><span class="badge bg-light text-dark border font-monospace px-2 py-1 fs-6">{{ $subject->code }}</span></td>
                            <td><strong class="text-dark">{{ $subject->name }}</strong></td>
                            <td class="text-center">
                                @if($subject->is_elective)
                                    <span class="badge bg-warning text-dark px-3 py-1"><i class="bi bi-shuffle me-1"></i> Elective Option</span>
                                @else
                                    <span class="badge bg-primary px-3 py-1"><i class="bi bi-shield-lock-fill me-1"></i> Core Requirement</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-outline-info me-1" title="Modify Subject Profile">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Warning: Purging this subject will delete historical exam structures tied directly to it. Proceed?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Purge Subject">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                No subject structures registered in the curriculum parameters.
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