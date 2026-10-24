@extends('layouts.master')
@section('title', 'Exam Terms Configuration')
@section('page-title', 'Assessment Term Blocks')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-outline shadow-sm" style="border-top: 3px solid #fd7e14;">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title fw-bold mb-0" style="color: #fd7e14;">Term Interval Mappings</h3>
                <a href="{{ route('exam-terms.create') }}" class="btn btn-sm text-white ms-auto" style="background-color: #fd7e14;">
                    <i class="bi bi-folder-plus me-1"></i> Register Term Structure
                </a>
            </div>
            
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Academic Year Parent</th>
                            <th>Term Descriptor Name</th>
                            <th class="text-center">Report Card Weightage</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($examTerms as $term)
                        <tr>
                            <td><span class="badge bg-secondary px-2 py-1">{{ $term->academicYear->name ?? 'N/A' }}</span></td>
                            <td><strong class="text-dark">{{ $term->name }}</strong></td>
                            <td class="text-center">
                                <div class="progress mb-0" style="height: 20px; min-width: 120px; max-width: 200px; margin: 0 auto;">
                                    <div class="progress-bar bg-warning text-dark fw-bold" role="progressbar" 
                                         style="width: {{ $term->weightage }}%;" 
                                         aria-valuenow="{{ $term->weightage }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $term->weightage }}%
                                    </div>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('exam-terms.edit', $term->id) }}" class="btn btn-sm btn-outline-info me-1" title="Modify Term Layout">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('exam-terms.destroy', $term->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Warning: Purging this exam term removes all child exams and grade sheets tied to it. This cannot be undone. Proceed?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Purge Term Block">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                No specialized assessment segments created for any academic schedules yet.
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