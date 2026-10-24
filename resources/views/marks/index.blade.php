@extends('layouts.master')
@section('title', 'Examination Ledger')
@section('page-title', 'Student Marks Registry')

@section('content')
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card card-outline card-crimson shadow-sm" style="border-top: 3px solid #dc3545;">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h3 class="card-title text-danger fw-bold mb-0">Academic Performance Matrix</h3>
                <a href="{{ route('marks.create') }}" class="btn btn-danger btn-sm ms-auto">
                    <i class="bi bi-patch-plus-fill me-1"></i> Input Performance Score
                </a>
            </div>
            
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Exam Component</th>
                            <th>Student Demographics</th>
                            <th>Class & Roll Allocation</th>
                            <th class="text-center">Score Secured</th>
                            <th>Evaluator Remarks</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marks as $mark)
                        <tr>
                            <td><strong class="text-dark">{{ $mark->exam->examTerm->name ?? 'Exam Node #'.$mark->exam_id }}</strong></td>
                            <td>
                                <span class="fw-bold">{{ $mark->studentEnrollment->student->first_name ?? 'N/A' }} {{ $mark->studentEnrollment->student->last_name ?? '' }}</span>
                                <div class="small text-muted">ID: {{ $mark->studentEnrollment->student->admission_no ?? 'Unlinked' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $mark->studentEnrollment->class->name ?? 'N/A' }}</span>
                                <div class="small text-muted mt-1">Roll Sequence: <strong>#{{ $mark->studentEnrollment->roll_no }}</strong></div>
                            </td>
                            <td class="text-center">
                                @if($mark->is_absent)
                                    <span class="badge bg-danger px-3 py-1 text-uppercase"><i class="bi bi-person-x-fill me-1"></i> Absent</span>
                                @else
                                    <span class="badge bg-success font-monospace px-3 py-1 fs-6">{{ $mark->marks_obtained }}</span>
                                @endif
                            </td>
                            <td><span class="text-muted small italic">{{ Str::limit($mark->teacher_remarks, 60, '...') ?? '—' }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('marks.edit', $mark->id) }}" class="btn btn-sm btn-outline-info me-1" title="Adjust Parameters">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('marks.destroy', $mark->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Purging this grade node will alter historic aggregate totals. Proceed?');">
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
                                <i class="bi bi-clipboard-x fs-1 d-block mb-2"></i>
                                No score indicators found registered in the active system ledger context.
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