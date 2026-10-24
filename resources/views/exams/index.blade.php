@extends('layouts.master')
@section('title', 'Exam Configurations')
@section('page-title', 'Assessment Schedules')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-outline shadow-sm" style="border-top: 3px solid #6f42c1;">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title fw-bold mb-0" style="color: #6f42c1;">Evaluation Roadmaps</h3>
                <a href="{{ route('exams.create') }}" class="btn btn-sm text-white ms-auto" style="background-color: #6f42c1;">
                    <i class="bi bi-calendar-plus me-1"></i> Setup Exam Specification
                </a>
            </div>
            
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Exam Term Block</th>
                            <th>Target Mapping (Subject > Division)</th>
                            <th>Evaluation Date</th>
                            <th class="text-center">Max Marks</th>
                            <th class="text-center">Passing Threshold</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                        <tr>
                            <td><strong class="text-dark">{{ $exam->examTerm->name ?? 'Term Context #'.$exam->exam_term_id }}</strong></td>
                            <td>
                                <span class="fw-bold">{{ $exam->subject->name ?? 'N/A' }}</span>
                                <div class="small text-muted">Section Track: {{ $exam->section->name ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border p-2">
                                    <i class="bi bi-calendar3 me-1 text-primary"></i> 
                                    {{ $exam->exam_date->format('Y-m-d') }}
                                </span>
                            </td>
                            <td class="text-center"><span class="badge bg-secondary font-monospace px-3 py-1 fs-6">{{ $exam->max_marks }}</span></td>
                            <td class="text-center">
                                <span class="badge bg-outline-danger font-monospace px-3 py-1 fs-6 border border-danger text-danger">
                                    {{ $exam->min_passing_marks }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-sm btn-outline-info me-1" title="Adjust Parameters">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('exams.destroy', $exam->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Warning: Deleting this exam will automatically drop all correlated student grades ledger elements. Proceed?');">
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
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                No assessments scheduled in the active system log.
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