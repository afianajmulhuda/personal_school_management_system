@extends('layouts.master')
@section('title', 'Academic Reports Center')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        
        <!-- Automated Roll No Generator -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 border-top border-primary" style="border-top-width: 4px !important;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-person-badge-fill me-2"></i>Roll Number Generator</h5>
                </div>
                <form action="{{ route('reports.regenerate-roll') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <p class="text-muted small">
                            Select a class. The system will sort all enrolled students alphabetically (Last Name, First Name) and assign sequential roll numbers directly to your existing database records.
                        </p>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Class</label>
                            <select name="class_id" class="form-select" required>
                                <option value="">Select a Class...</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <button type="submit" class="btn btn-primary btn-sm fw-bold w-100">
                            <i class="bi bi-magic me-1"></i> Auto-Generate Roll Numbers
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Marksheet Generation Console -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 border-top border-success" style="border-top-width: 4px !important;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success"><i class="bi bi-file-earmark-spreadsheet-fill me-2"></i>Class Marksheet Console</h5>
                </div>
                <form action="{{ route('reports.marksheet-class') }}" method="GET" target="_blank">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Select Class</label>
                                <select name="class_id" class="form-select" required>
                                    <option value="">Select Class...</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Select Exam Term</label>
                                <select name="exam_term_id" class="form-select" required>
                                    <option value="">Select Term...</option>
                                    @foreach($examTerms as $term)
                                        <option value="{{ $term->id }}">{{ $term->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <button type="submit" class="btn btn-success btn-sm fw-bold w-100">
                            <i class="bi bi-printer-fill me-1"></i> Generate Consolidated Marksheet
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection